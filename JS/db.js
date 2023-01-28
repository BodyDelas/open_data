function act() {
  const mysql = require("mysql");

  //конфигурация
  const conn = mysql.createConnection({
    host: "localhost",
    user: "mysql",
    database: "open_data",
    password: "mysql",
  });

  conn.connect((err) => {
    if (err) {
      console.log(err);
      return err;
    } else {
      console.log("Database ----- OK");
    }
  });

  let query = "SELECT * FROM open_data";

  conn.query(query, (err, result, field) => {
    const items = result;

    for (let i = 0; i < 10; i++) {
      console.log(items[i]);
    }
  });
}

act();
