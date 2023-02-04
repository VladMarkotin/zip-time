/*Hidden*/
const observer = new IntersectionObserver((enteries) => {
  enteries.forEach((entry) => {
    if (entry.isIntersecting){
      entry.target.classList.add('show')
    } else {
      entry.target.classList.remove('show')
    }
  })
})

const hiddenElements = document.querySelectorAll('.hidden')
hiddenElements.forEach((el) => observer.observe(el))