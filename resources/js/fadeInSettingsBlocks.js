document.addEventListener('DOMContentLoaded', function() {
    let savedTasksButton = document.querySelector('.saved-tasks-button');
    let statisticButton = document.querySelector('.statistic-button');
    let personalSettingsButton = document.querySelector('.personal-settings-button');
    // console.log(btn);

    savedTasksButton.addEventListener('click', function() {
        let table = document.querySelector('.saved-tasks-table');
        
        // table.style.display == ('none') ?   table.style.display = 'block' : 
        //                                     table.style.display = 'none';
                                        
        if (table.style.display == ('none')) {
            setTimeout(function() {
                table.style.display = ('block');
            }, 50)
            this.classList.add('onclick');
        } else {
            table.style.display = ('none');
            this.classList.remove('onclick');
        }
    })

    statisticButton.addEventListener('click', function() {
        let table = document.querySelector('.statistic-block');
        
        // table.style.display == ('none') ?   table.style.display = 'block' : 
        //                                     table.style.display = 'none';

        if (table.style.display == ('none')) {
            setTimeout(function() {
                table.style.display = ('block');
            }, 50)
            this.classList.add('onclick');
        } else {
            table.style.display = ('none');
            this.classList.remove('onclick');
        }
    })

    personalSettingsButton.addEventListener('click', function() {
        let table = document.querySelector('.personal-settings-block');
        
        // table.style.display == ('none') ?   table.style.display = 'block' : 
        //                                     table.style.display = 'none';
        
        if (table.style.display == ('none')) {
            setTimeout(function() {
                table.style.display = ('block');
            }, 50)
            this.classList.add('onclick');
        } else {
            table.style.display = ('none');
            this.classList.remove('onclick');
        }
    })
})




