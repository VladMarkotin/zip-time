@extends('layouts.app')

<style>
*{
  margin: 0;
  padding: 0;
}
body{
  background: #ffffff;
}
@font-face {
  font-family: "Constantine";
  src: url("./font/Constantine.ttf") format("truetype");
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
  color: #c92020;
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
  left: 355px;
}

.nameSite span:nth-child(3){
  left: 155px;
  position: absolute;
  animation-duration: 1.5s;
  animation-name: go;
}
@keyframes go{
  0% { left: 275px; }
  75% { left: 275px; }
  100% { left: 155px; }
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
  left: 275px;
  position: absolute;
  animation-duration: 1.5s;
  animation-name: goto;
}
@keyframes goto{
  0% { left: 155px; }
  25% { left: 275px; }
  100% { left: 275px; }
}

/* защита от выделения */
p::selection {
  background: transparent;
}
p::-moz-selection {
  background: transparent;
}

/*-----Блок текста------*/
.flex{
  background: #ffb7b7;
  text-align: center;
  width: 1000px;
  height: 300px;
  overflow: hidden;
  box-shadow: 2px 2px 5px #5e5e5e;
  margin: 20px auto;
  display: flex;
  flex-flow: row nowrap;
  align-items: center;
  transition: .5s;
}
.flex:hover{
  box-shadow: 2px 2px 5px #000000;
  transition: .5s;
}
</style>

@section('content')
<div class="nameSite">
  <span>Qui</span><span>ck </span><span>pl</span><span>an</span>
</div>
<div class="flex">
  <p class="one">
    Cras accumsan vitae felis eu varius. 
    Nulla cursus justo sit amet semper accumsan. 
    Ut tincidunt purus vestibulum dui fermentum, 
    eu volutpat felis ullamcorper. Donec et nulla dui. 
    In ullamcorper bibendum nulla, id suscipit purus lacinia sit amet.
  </p>
  <img class="two" src="https://via.placeholder.com/300/">
</div>
<div class="flex">
  <img class="two" src="https://via.placeholder.com/300/">
  <p class="one">
    Cras accumsan vitae felis eu varius. 
    Nulla cursus justo sit amet semper accumsan. 
    Ut tincidunt purus vestibulum dui fermentum, 
    eu volutpat felis ullamcorper. Donec et nulla dui. 
    In ullamcorper bibendum nulla, id suscipit purus lacinia sit amet.
  </p>
</div>
<div class="flex">
  <p class="one">
    Cras accumsan vitae felis eu varius. 
    Nulla cursus justo sit amet semper accumsan. 
    Ut tincidunt purus vestibulum dui fermentum, 
    eu volutpat felis ullamcorper. Donec et nulla dui. 
    In ullamcorper bibendum nulla, id suscipit purus lacinia sit amet.
  </p>
  <img class="two" src="https://via.placeholder.com/300/">
</div>

@endsection