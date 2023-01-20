const placesList = document.querySelector('.places');
const hasLightningCheckbox = document.querySelector('.has-lightning');
const areaSelect = document.querySelector('#areaSelect');
const elementsSelect = document.querySelector('#elementsSelect');

let placesToShow = [];

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

      item.addEventListener('click', (event) => {
        event.preventDefault();

        const text = event.currentTarget.textContent;
        const address = text.slice(
          text.indexOf(':') + 2,
          text.indexOf('Есть освещение')
        );

        let control = outerMap.controls.get('routePanelControl');

        control.routePanel.options.set({
          types: {
            pedestrian: true,
            // masstransit: true,
            // taxi: true,
          },
        });
        //при загрузке выбор места
        control.routePanel.state.set({
          type: 'pedestrian',
          //можно проставит фолс для фиксированного начального места
          fromEnabled: true,
          from: myLocation,
          //from: `Москва, Малая Семёновская 12`,
          toEnabled: true,
          to: address, //`${city}, Большая Почтовая улица 40`, // передать координаты
        });
        //изменение вов ремя пользования транспорта
      });

      placesList.append(item);
    }

    set.add(place.location);
  });

  const map = document.querySelector('.ymaps-2-1-79-map');
  map.parentNode.removeChild(map);

  ymaps.ready(init);
}
