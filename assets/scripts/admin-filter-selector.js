const selectElement = document.getElementById("filter-select");
    const filterList = document.getElementById("filter-list");
    let noItems = filterList.querySelector(".no-items");
    let moveUpButtons = filterList.querySelectorAll('.move-up');
    let moveDownButtons = filterList.querySelectorAll('.move-down');
    let deleteButtons = filterList.querySelectorAll('.item-delete');
    const optionName = document.querySelector('.kapital-post-filters-form input[name="option_page"]').value;
   
    function addListernersDelete(){
        deleteButtons = filterList.querySelectorAll('.item-delete');
        for (let i = 0; i < deleteButtons.length; i++){
            let button = deleteButtons[i];
            button.addEventListener("click", deleteItem);
        }
    };

    function addListernersMoveUp(){
        moveUpButtons = filterList.querySelectorAll('.move-up');
        for (let i = 0; i < moveUpButtons.length; i++){
            let button = moveUpButtons[i];
            button.addEventListener("click", moveUp);
        }
    }
    function addListernersMoveDown(){
        moveUpButtons = filterList.querySelectorAll('.move-down');
        for (let i = 0; i < moveUpButtons.length; i++){
            let button = moveUpButtons[i];
            button.addEventListener("click", moveDown);
        }
    }


    addListernersDelete();
    addListernersMoveUp();
    addListernersMoveDown();


    function deleteItem(event){
        event.preventDefault();
        event.target.closest('.filter-row').remove();   
        if(filterList.children.length <= 1){    
            noItems.classList.remove("false");
        }
    }

    function moveUp(event){
        event.preventDefault();
        let row = event.target.closest('.filter-row');
        let prev_row = event.target.closest('.filter-row').previousElementSibling;
        if (!prev_row.classList.contains("no-items")){
            row.after(prev_row);
        };
    }

    function moveDown(event){
        event.preventDefault();
        let row = event.target.closest('.filter-row');
        let next_row = event.target.closest('.filter-row').nextElementSibling;
        if (next_row){
            next_row.after(row);
        }; 
    }
    selectElement.addEventListener("change", renderFilterOnSelect);

    function renderFilterOnSelect(){        
        let text = selectElement.options[selectElement.selectedIndex].text;
        let value = event.target.value;
        filterList.innerHTML += '<tr class="filter-row"><input type="hidden" name="' + optionName + '[]" value="' + value + '"/><td><div class="filter-item">' + text + '</div></td><td><a href="" class="dashicons move-down dashicons-arrow-down-alt2"></a></td><td><a href="" class="dashicons move-up dashicons-arrow-up-alt2"></a></td><td><a href="" class="item-delete">Odstrániť filter</a></td></tr>';
        selectElement.selectedIndex = 0;
        noItems = filterList.querySelector(".no-items"); //no idea why I need to do this again
        if(filterList.children.length > 1){
            noItems.classList.add("false");
        }
        addListernersDelete();
        addListernersMoveUp();
        addListernersMoveDown();
    }