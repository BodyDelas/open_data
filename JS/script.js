let center = [55.78435926711707, 37.71102060324103];
let data = [];
const targets = [];

const placesList = document.querySelector('.places');
const hasLightningCheckbox = document.querySelector('.has-lightning');
const areaSelect = document.querySelector('#areaSelect');
const elementsSelect = document.querySelector('#elementsSelect');

let myLocation;
let outerMap;

let placesToShow = [];

function getCenters(arr) {
  data = arr;
}

function init() {
  //Координаты на карте
  map = new ymaps.Map("map", {
    center: center,
    zoom: 17,
    controls: ["routePanelControl"],
  });

  outerMap = map;

  let control = map.controls.get("routePanelControl");
  let city = "Москва";

  //получаем локаицю(получили промис)
  let location = ymaps.geolocation.get();

  //Работа с элементами на карте
  data.forEach(target => targets.push(decompose(target)))

  let placemarkes = [];

  if (placesToShow.length === 0) {
    data.forEach(row => {
      const decomposedRow = decompose(row);

      placemarkes.push(new ymaps.Placemark(
            decomposedRow.coordinates,
            {
              //балуны на карте
              balloonContentHeader: "Площадка для выгула собак",
              balloonContentBody: decomposedRow.elements,
              balloonContentFooter: decomposedRow.location,
            },
            {
              //использовать свою картинку
              iconLayout: "default#image",
              //руть к картинке
              iconImageHref:
                "https://cdn-icons-png.flaticon.com/512/8065/8065913.png",
              //размер
              iconImageSize: [40, 40],
              //отступ от центра
              iconImageOffset: [-20, -40],
            }
          ),)
    })

    showPlaces(targets)
  } else {
    console.log(placesToShow);
    placesToShow.forEach(place => {
      placemarkes.push(new ymaps.Placemark(
        place.coordinates,
        {
          //балуны на карте
          balloonContentHeader: "Площадка для выгула собак",
          balloonContentBody: place.elements,
          balloonContentFooter: place.location+`
            <form>
              `+place['id']+`
            </form>
          `,
        },
        {
          //использовать свою картинку
          iconLayout: "default#image",
          //руть к картинке
          iconImageHref:
            "https://cdn-icons-png.flaticon.com/512/8065/8065913.png",
          //размер
          iconImageSize: [40, 40],
          //отступ от центра
          iconImageOffset: [-20, -40],
        })
      )
    })
  }

  for (var i = 0; i < placemarkes.length; i++) {
    map.geoObjects.add(placemarkes[i]);
  }

  location
    .then(function (res) {
      //передаем 0 элемент текста
      let locationText = res.geoObjects.get(0).properties.get("text");
      myLocation = res.geoObjects.get(0).geometry.getCoordinates();

      // Расстояние до ближайшего
      let minPlaceIdx = -1;
      let minPlaceVal = 100000;

      for (let i = 0; i < placemarkes.length; i++) {
        let dist = Math.pow(
          Math.pow(
            myLocation[0] - placemarkes[i].geometry.getCoordinates()[0],
            2
          ) +
            Math.pow(
              myLocation[1] - placemarkes[i].geometry.getCoordinates()[1],
              2
            ),
          0.5
        );
        if (dist < minPlaceVal) {
          minPlaceVal = dist;
          minPlaceIdx = i;
        }
      }

      control.routePanel.options.set({
        types: {
          pedestrian: true,
          // masstransit: true,
          // taxi: true,
        },
      });
      //при загрузке выбор места
      control.routePanel.state.set({
        type: "pedestrian",
        //можно проставит фолс для фиксированного начального места
        fromEnabled: true,
        from: myLocation,
        //from: `Москва, Малая Семёновская 12`,
        toEnabled: true,
        to: placemarkes[minPlaceIdx].properties._data.balloonContentFooter, //`${city}, Большая Почтовая улица 40`, // передать координаты
      });
      //изменение вов ремя пользования транспорта
    })
    .catch((error) => console.log(error));
}

function decompose(strs) {
  const coordinates = strs[4]
    .slice(strs[4].indexOf('[') + 1, strs[4].indexOf(']'))
    .split(',')
    .reverse();
  coordinates[0] = +coordinates[0];
  coordinates[1] = +coordinates[1];

  const elements = strs[2].slice(1, -1);

  const place = {
    location: strs[0],
    area: +strs[1],
    elements,
    hasLightning: strs[3],
    coordinates,
  };

  return place;
}

hasLightningCheckbox.addEventListener('change', (event) => {
  event.preventDefault();
  showPlaces(targets);
});

areaSelect.addEventListener('change', (event) => {
  event.preventDefault();
  showPlaces(targets);
});

elementsSelect.addEventListener('change', (event) => {
  event.preventDefault();
  showPlaces(targets);
});

function showPlaces(list) {
  placesList.innerHTML = '';

  placesToShow = list.filter((place) => {
    if (hasLightningCheckbox.checked && place.hasLightning === 'нет') {
      return false;
    }

    switch (areaSelect.value) {
      case 'small':
        if (place.area > 200) return false;
        break;
      case 'medium':
        if (place.area < 200 || place.area > 400) return false;
        break;
      case 'large':
        if (place.area < 400) return false;
        break;
    }

    switch (elementsSelect.value) {
      case 'barrier':
        if (!place.elements.includes('барьер')) return false;
        break;
      case 'urn':
        if (!place.elements.includes('урна')) return false;
        break;
      case 'chute':
        if (!place.elements.includes('горка')) return false;
        break;
    }

    return true;
  });

  const set = new Set();
  
  placesToShow.forEach((place) => {
    if (!set.has(place.location)) {
      let item = document.createElement('div');

      item.classList.add('place');
      item.innerHTML =
        `Адрес: ${place.location}<br>Есть освещение: ${place.hasLightning}` +
        `<br>Размер площадки: ${place.area} м2<br>Есть на площадке: ${place.elements}`;
      
      item.addEventListener('click', event => {
        event.preventDefault();

        const text = event.currentTarget.textContent;
        const address = text.slice(text.indexOf(":") + 2, text.indexOf('Есть освещение'));

        let control = outerMap.controls.get("routePanelControl");

        control.routePanel.options.set({
          types: {
            pedestrian: true,
            // masstransit: true,
            // taxi: true,
          },
        });
        //при загрузке выбор места
        control.routePanel.state.set({
          type: "pedestrian",
          //можно проставит фолс для фиксированного начального места
          fromEnabled: true,
          from: myLocation,
          //from: `Москва, Малая Семёновская 12`,
          toEnabled: true,
          to: address, //`${city}, Большая Почтовая улица 40`, // передать координаты
        });
        //изменение вов ремя пользования транспорта
      })
      

      placesList.append(item);
    }

    set.add(place.location);
  });
  

  const map = document.querySelector('.ymaps-2-1-79-map');
  map.parentNode.removeChild(map);

  ymaps.ready(init);
}

 // map.geoObjects.add(placemark); //добавить элемент на карту

  //map.controls.remove("geolocationControl"); // удаляем геолокацию
  //map.controls.remove("searchControl"); // удаляем поиск
  //map.controls.remove("trafficControl"); // удаляем контроль трафика
  //map.controls.remove("typeSelector"); // удаляем тип
  //map.controls.remove("fullscreenControl"); // удаляем кнопку перехода в полноэкранный режим
  //map.controls.remove("zoomControl"); // удаляем контрол зуммирования
  //map.controls.remove("rulerControl"); // удаляем контрол правил
  //map.behaviors.disable(["scrollZoom"]); // отключаем скролл карты (опционально)
