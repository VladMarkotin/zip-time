@extends('layouts.app')

<style>
  *{
  margin: 0;
  padding: 0;
}
body{
  background: #fff;
}

@font-face {
  font-family: "Constantine";
  src: url("./font/Constantine.ttf") format("truetype");
}
@font-face {
  font-family: "Playfair";
  src: url("./font/PlayfairDisplaySC-Bold.ttf") format("truetype");
}
@font-face {
  font-family: "Karma";
  src: url("./font/Karma-Regular.ttf") format("truetype");
}
p{
  font-family: "Karma";
}

/* цвет выделения текста */
::selection {
background: #ffb7b7; /* Safari */
}
::-moz-selection {
background: #ffb7b7; /* Firefox */
}
/* защита от выделения баннера */
.nameSite span::selection {
  background: transparent;
}
.nameSite span::-moz-selection {
  background: transparent;
}

.nameSite{
  font-family: "Constantine";
  font-size: 100px;
  color: #ffffff;
  text-shadow: 2px    2px    5px  #5e5e5e,
               1px    1px    0    #000000,
              -1px   -1px    0    #000000,
              -1px    1px    0    #000000,
               1px   -1px    0    #000000;
  display: inline;
  position: relative;
}

.nameSite span:nth-child(2),
.nameSite span:nth-child(4)
{
  color: #ffffff;
  animation-duration: 1.5s;
  animation-name: slideOut;
  opacity: 0;
}

@keyframes slideOut {
  0% { opacity: 1; }
  25% { opacity: 1; }
  100% { opacity: 0; }
}
/* спец.позиция для последнего элемента */
.nameSite span:nth-child(4)
{
  position: absolute;
  left: 450px;
}

.nameSite span:nth-child(3){
  left: 190px;
  position: absolute;
  animation-duration: 1.5s;
  animation-name: go;
}
@keyframes go{
  0% { left: 342px; }
  75% { left: 342px; }
  100% { left: 190px; }
}

.nameSite:hover>span:nth-child(2),
.nameSite:hover>span:nth-child(4)
{
  display: inline;
  /* анимация выделения */
  animation-duration: 1.5s;
  animation-name: slideIn;
  opacity: 1;
}

@keyframes slideIn {
  0% { opacity: 0; }
  25% { opacity: 0; }
  100% { opacity: 1; }
}

.nameSite:hover>span:nth-child(3){
  left: 342px;
  position: absolute;
  animation-duration: 1.5s;
  animation-name: goto;
}

@keyframes goto{
  0% { left: 190px; }
  25% { left: 342px; }
  100% { left: 342px; }
}

/*-----Login-----*/
.login{
  display: flex;
  justify-content: center;
}

.menu{
  background-color: #c02020;
  margin-bottom: 25px;
  padding-bottom: 20px;
  padding-left: 3%;
  background-image: url(564.jpg);
  background-size: contain;
}

.footer{
  background-color: #c02020;
  margin-top: 25px;
  padding-bottom: 20px;
  padding-left: 3%;
  background-image: url(564.jpg);
  background-size: contain;
}

.inline{
  display: flex;
  justify-content: space-between;
  padding: 25px 10% 0 0;
}

/*-----Блок текста------*/

.flex{
  display: flex;
  width: 1000px;
  margin: 20px auto;
  align-items: center;
  transition: .5s;
}

.one{
  background: #d42121;
}

.two{
  color: rgb(0, 0, 0);
  text-align: justify;
  text-indent: 20px;
  background-color: #ebebeb;
  height: 210px;
  padding: 10px 20px;
}

.three{
  margin-left: 20px;
  margin-right: 20px;
  box-shadow: 2px 2px 5px #5e5e5e;
  border: 1px solid #5e5e5e;
}

.title{
  font-family: "Playfair";
  color: #fff;
  font-size: 50px;
  background-image: url(564.jpg);
  background-size: 30%;
  text-align: center;
  text-shadow: 2px    2px    5px  #5e5e5e,
               1px    1px    0    #000000,
              -1px   -1px    0    #000000,
              -1px    1px    0    #000000,
               1px   -1px    0    #000000;
}

.null{
  display: flex;
  flex-direction: column;
  box-shadow: 2px 2px 5px #5e5e5e;
  border: 1px solid #5e5e5e;
  margin-left: 20px;
  margin-right: 20px;
  transition: 1s;
  border-radius: 7px;
  overflow: hidden;
}

.null:hover{
  transform: scale(1.03);
}

.white{
  color: #dddddd;
}
</style>


@section('content')


<header class="menu">
      <div class="nameSite">
        <span>Qui</span><span>ck </span><span>pl</span><span>an</span>
      </div>
    </header>

    <!-- Facebook login автоматическая кнопка от Meta
      data-auto-logout-link="false" для отобр. вход как {name}
      https://developers.facebook.com/docs/facebook-login/web/login-button/
    -->
    <div class="login">
      <div class="fb-login-button" 
           data-width="" 
           data-size="large" 
           data-button-type="continue_with" 
           data-layout="rounded" 
           data-auto-logout-link="false"
           data-use-continue-as="false">
      </div>
    </div>
    
    <div class="flex">
      <div class="null">
        <div class ="one">
          <p class="title">Title</p>
        </div>
        <div class="two">
          <p class ="content">
            Cras accumsan vitae felis eu varius. 
            Nulla cursus justo sit amet semper accumsan. 
            Ut tincidunt purus vestibulum dui fermentum, 
            eu volutpat felis ullamcorper. Donec et nulla dui. 
            In ullamcorper bibendum nulla, id suscipit purus lacinia sit amet.
          </p>
        </div>
      </div>
      <img class="three" src="https://via.placeholder.com/300/">
    </div>

    <div class="flex">
      <img class="three" src="https://via.placeholder.com/300/">
      <div class="null">
        <div class ="one">
          <p class="title">Title</p>
        </div>
        <div class="two">
          <p class ="content">
            Cras accumsan vitae felis eu varius. 
            Nulla cursus justo sit amet semper accumsan. 
            Ut tincidunt purus vestibulum dui fermentum, 
            eu volutpat felis ullamcorper. Donec et nulla dui. 
            In ullamcorper bibendum nulla, id suscipit purus lacinia sit amet.
          </p>
        </div>
      </div>
    </div>

    <div class="flex">
      <div class="null">
        <div class ="one">
          <p class="title">Title</p>
        </div>
        <div class="two">
          <p class ="content">
            Cras accumsan vitae felis eu varius. 
            Nulla cursus justo sit amet semper accumsan. 
            Ut tincidunt purus vestibulum dui fermentum, 
            eu volutpat felis ullamcorper. Donec et nulla dui. 
            In ullamcorper bibendum nulla, id suscipit purus lacinia sit amet.
          </p>
        </div>
      </div>
      <img class="three" src="https://via.placeholder.com/300/">
    </div>

    <footer class="footer">
      <div class="inline">
      <div class="nameSite">
        <span>Quipl</span>
      </div>
      <div class="white">
        <p>Corporate</p>
        <p>User agreement</p>
        <p>Privacy Policy</p>
        <p>Cookie Policy</p>
        <p>Support</p>
      </div>
      <div class="white">
        <p>© 2022 All rights reserved</p>
      </div>
    </footer>

@endsection