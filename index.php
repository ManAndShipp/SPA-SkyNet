<?php
$url = "https://www.sknt.ru/job/frontend/data.json";
$json = file_get_contents($url);
?>

<?php
  echo '<script language="javascript">
  let result = '.$json.';
  console.log(result);
  </script>';
?>



<!DOCTYPE html>
<html lang="ru">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>SPA for SkyNet</title>
  <link rel="stylesheet" href="./src/css/style.css">
  <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500&display=swap" rel="stylesheet">
</head>

<body>
  <section id='nav' class='choose'>
    <span>
      Выбор тарифа
    </span>
  </section>
  <section id='app' class='tariff--section'>

  </section>

<script>
//My little bit SPA ;)
const data = result.tarifs;
console.log(data);

let store = {
	mainCards: {
		content: '',
		traffics: []
	}
};

let app = document.getElementById('app');

const init = () => {
	if (data) {
		let id = 0;
		store.mainCards.content = '';
		data.map(el => {
			let newtraffic = {
				id: id,
				min: 40000,
				max: 0,
				header: el.title,
				content: '',
				price: el.price,
				pay_period: el.pay_period,
				elememts: []
			};
      store.mainCards.traffics = [...store.mainCards.traffics, newtraffic];


			idx = 0;
			el.tarifs.map(tarif => {
        console.log(store.mainCards.traffics[id].min);
        if(tarif.price/tarif.pay_period < store.mainCards.traffics[id].min)
          store.mainCards.traffics[id].min =tarif.price/tarif.pay_period;
        if(tarif.price/tarif.pay_period > store.mainCards.traffics[id].max)
          store.mainCards.traffics[id].max = tarif.price/tarif.pay_period;

				store.mainCards.traffics[id].content =
					store.mainCards.traffics[id].content +
					`<div class='tariff'>
					<h2 class='tariff_header'>` +
					tarif.title +
					`</h2>
					<div class='tariff-break'></div>
					<div onClick="lastStep('` +
					id +
					`','` +
					idx +
					`')" class='tariff_content'>
						<div class='tariff_content--data'>
							<div class='tariff_content--data_price'>
								` +
					tarif.price / tarif.pay_period +
					`Р/мес
							</div>
							<ul class='tariff_content--data_descriptions'>
								<li>Разовый платеж - ` +
					tarif.price +
					`р</li>
								<li>Скидка - *Скидка*</li>
							</ul>
						</div>
						<div class='arrow'>
							<div class='arrow_up'></div>
							<div class='arrow_down'></div>
						</div>
					</div>
        </div>`;
				let newSomeItem = {
					id: idx,
					content:
						`<div class='tariff'>
					<h2 class='tariff_header'>` +
						tarif.title +
						`</h2>
					<div class='tariff-break'></div>
					<div class='tariff_content tariff_content--nohever'>
						<div class='tariff_content--data'>
							<div class='tariff_content--data_price'>
								Период оплаты - ` +
						tarif.pay_period +
						` месяцев ` +
						tarif.price / tarif.pay_period +
						` Р/мес
							</div>
							<ul class='tariff_content--data_descriptions'>
								<li>Разовый платеж - ` +
						tarif.price +
						` Р</li>
								<li>Со счета спишется - ` +
						tarif.price +
						` Р</li>
							</ul>
							<ul class='tariff_content--data_meta'>
								<li>Вступит в силу - сегодня</li>
								<li>активно до - 10.01.2017</li>
							</ul>
						</div>
						<div class='tariff-break'></div>
					</div>
					<button class='tariff-button'>Выбрать</button>
				</div>`
				};
				idx++;
				store.mainCards.traffics[id].elememts = [
					...store.mainCards.traffics[id].elememts,
					newSomeItem
				];
      });
      			store.mainCards.content =
				store.mainCards.content +
				`<div class='tariff'>
      <h2 class='tariff_header'>` +
				el.title +
				`</h2>
      <div class='tariff-break'></div>
      <div id='mainCard-` +
				id +
				`' onClick="firtsStep('` +
				id +
				`')" class='tariff_content'>
        <div class='tariff_content--data'>
          <div class='tariff_content--data_mbits tariff--colors-brown'>
            <div>` +
				el.speed +
				` Мбит/с</div>
          </div>
          <div class='tariff_content--data_price'>`+store.mainCards.traffics[id].min+`-`+store.mainCards.traffics[id].max+` Р/мес</div>
        </div>
        <div class='arrow'>
          <div class='arrow_up'></div>
          <div class='arrow_down'></div>
        </div>
      </div>
      <div class='tariff-break'></div>
      <a target="_blank" href='` +
				el.link +
				`' class='tariff_link'>
        узнать более подробно на сайте www.sknt.ru
      </a>
    </div>`;
			id++;
      return 0;
      
    });
	} else init();
};

window.onload = init();
app.innerHTML = store.mainCards.content;

const firtsStep = id => {
	let nav = document.getElementById('nav');
	nav.onclick = () => {
		backToFirstPage();
	};
	nav.innerHTML =
		`<div id='nav-arrow'" 
  class='arrow arrow-reverse'>
      <div class='arrow_up'></div>
      <div class='arrow_down'></div>
    </div>
    <span id='nav-text'>
      ` +
		store.mainCards.traffics[id].header +
		`
    </span>`;
	app.innerHTML = store.mainCards.traffics[id].content;
};

const lastStep = (id, idx) => {
	let nav = document.getElementById('nav');
	nav.onclick = () => {
		backToSecondPage(id);
	};
	nav.innerHTML =
		`<div id='nav-arrow'" 
  class='arrow arrow-reverse'>
      <div class='arrow_up'></div>
      <div class='arrow_down'></div>
    </div>
    <span id='nav-text'>
      ` +
		store.mainCards.traffics[id].header +
		`
    </span>`;
	app.innerHTML = store.mainCards.traffics[id].elememts[idx].content;
};

const backToFirstPage = () => {
	let nav = document.getElementById('nav');
	nav.onclick = () => {};
	nav.innerHTML = `
    <span id='nav-text'>
      Выбор тарифа
    </span>`;
	app.innerHTML = store.mainCards.content;
};

const backToSecondPage = id => {
	let nav = document.getElementById('nav');
	nav.onclick = () => {
		backToFirstPage();
	};
	nav.innerHTML =
		`<div id='nav-arrow'" 
  class='arrow arrow-reverse'>
      <div class='arrow_up'></div>
      <div class='arrow_down'></div>
    </div>
    <span id='nav-text'>
      ` +
		store.mainCards.traffics[id].header +
		`
    </span>`;
	app.innerHTML = store.mainCards.traffics[id].content;
};

const routePage = () => {
	if (result) {
	} else return 'SPINNER';
};

</script>

</body>

</html>