@extends('layouts.app')

@section('content')

  <section class="smooth-section">
    <div class="hidden">
      <h2>Hi Vlad & Kate!</h2>
      <p>This is a QUIPL index page presentation</p>
    </div>
  </section>
  
  <section class="smooth-section">
    <div class="hidden">
      <h2>Features #1</h2>
      <h3>Title</h3>
      <p>Заголовок проигрывает анимацию при запуске</p>
      <p>А также каждый раз когда на него наведен курсор.</p>
      <div class="nameSite">
        <span>Qui</span><span>ck </span><span>pl</span><span>an</span>
      </div>
    </div>
  </section>

  <section class="smooth-section">
    <div class="hidden">
      <h2>Features #2</h2>
      <p>По мере прокрутки текста блоки появляются из "невидимости" эффектом смещения и блюра.</p>
      <p>Наблюдатель следит за тем что находится на экране, добавляя новый класс.</p>
      <p>Как только блок скрывается из вида - блок снова скрывается.</p>
    </div>
  </section>

  <section class="smooth-section">
    <div class="hidden">
      <h2>Features #3</h2>
      <p>Страница представляет собой секции-слайды, по которым происходит плавный переход при прокрутке страницы.</p>
      <p>Справа есть виджет для плавного перехода по страницам-слайдам.</p>
      <p>Он генерируется автоматически при инициализации страницы.</p>
    </div>
  </section>

  <section class="smooth-section">
    <div class="hidden">
      <h2>Features #4</h2>
      <h3>Accordion</h3>
      <p>Блок с текстом внутри: плавно выезжающий блок, анимация стрелки, смена стилей</p>
      <p>Всё, как у людей.</p>
      <div class="faq">
        <div class="faq_item">
          <div class="faq_header">
            Question 1
          </div>
          <div class="faq_body">
            <div class="faq_content">
              Lorem ipsum dolor sit amet consectetur adipisicing elit. Obcaecati consequuntur autem, mollitia rem aperiam
              fugit eos officia vel quidem quis officiis dolores porro beatae veritatis tenetur. Culpa ex libero a!
            </div>
          </div>
        </div>
        <div class="faq_item">
          <div class="faq_header">
            Question 2
          </div>
          <div class="faq_body">
            <div class="faq_content">
              Lorem ipsum dolor sit amet consectetur adipisicing elit. Ea dignissimos a autem perspiciatis sit eum
              exercitationem expedita omnis ipsam voluptate veritatis dolores similique eligendi, earum quasi officia in
              facilis dolorum!
            </div>
          </div>
        </div>
        <div class="faq_item">
          <div class="faq_header">
            Question 3
          </div>
          <div class="faq_body">
            <div class="faq_content">
              Lorem ipsum, dolor sit amet consectetur adipisicing elit. Dicta pariatur dolore consectetur perferendis libero
              nam sit magni voluptatibus voluptates autem nesciunt, praesentium quidem deserunt ipsa totam esse ullam? Quod,
              maiores!
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="smooth-section">
    <div class="hidden">
      <h2>Thank you for your attention</h2>
      <p>It's really good!</p>
    </div>
  </section>

  <script defer src="js/style-index.js"></script>
  <script defer src="js/title.js"></script>

@endsection