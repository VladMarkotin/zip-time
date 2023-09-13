document.addEventListener('DOMContentLoaded', function() {
    let savedTasksButton = document.querySelector('.saved-tasks-button');
    let statisticButton = document.querySelector('.statistic-button');
    let personalSettingsButton = document.querySelector('.personal-settings-button');
    // console.log(btn);

    savedTasksButton.addEventListener('click', function() {
        let table = document.querySelector('.saved-tasks-table');
        
        table.style.display == ('none') ?   table.style.display = 'block' : 
                                            table.style.display = 'none';
    })

    statisticButton.addEventListener('click', function() {
        let table = document.querySelector('.statistic-block');
        
        table.style.display == ('none') ?   table.style.display = 'block' : 
                                            table.style.display = 'none';
    })

    personalSettingsButton.addEventListener('click', function() {
        let table = document.querySelector('.personal-settings-block');
        
        table.style.display == ('none') ?   table.style.display = 'block' : 
                                            table.style.display = 'none';
    })
})

