/**
 * Fonction qui s'occupe d'afficher un dropDown pour choisir sa langue
 */
function dropdownFlags(){
    const flagDropdown = document.querySelector('div.dropdown-flags');
    const flagButton = document.querySelector('button.btn-flag');
    flagDropdown.style.display = "none";
    flagButton.addEventListener('click',()=>{

        if ( flagDropdown.style.display === "none" ){
            flagDropdown.style.display = "block";
            flagDropdown.style.transition = "backgroundColor 0.5s ";

        }else{
            flagDropdown.style.display = "none";
        }
        //flagDropdown.classList.toggle("show");

    })

    const frFlagButton = document.querySelector('button.btn-flag-fr');
    const usFlagButton = document.querySelector('button.btn-flag-us');

    frFlagButton.addEventListener('click',()=>{
        let currentFlag = document.querySelector('img.btn-img');
        currentFlag.src = "/image/flags/france.png";
        flagDropdown.style.display = "none";

    })

    usFlagButton.addEventListener('click',()=>{
        let currentFlag = document.querySelector('img.btn-img');
        currentFlag.src = "/image/flags/united-states.png";
        flagDropdown.style.display = "none";

    })

}

/**
 * Quand la taille de l'écran est trop petit, les liens sont mis dans un dropdown
 */
function dropdownLinks(){
    const linkNoDropDown = document.querySelectorAll("li.no-dropdown");
    const linkWithDropDown = document.querySelector('div.with-dropdown');
    const dropDownButton = document.querySelector('button.btn-dropdown');
    if(screen.width <= 480){
        dropDownButton.style.display = 'inline-block';
        linkNoDropDown.forEach((el)=>{el.style.display = 'none'});
        dropDownButton.addEventListener('click',()=>{
            linkWithDropDown.style.display = "flex";
        })
    }else{
        dropDownButton.style.display = 'none';
        linkNoDropDown.forEach((el)=>{el.style.display = 'block'});
    }

}

/**
 * Lance une cherche par catégorie lorsque la valeur du dropdown change
 */
function startSearchOnChange(){
    const dropDown = document.querySelector("select.dropdown-category");
    const submitBtn = document.querySelector("button.btn-category");
    const form = document.querySelector("form.carte-category")
    dropDown.addEventListener("change",()=>{
        form.submit();
    })
}

dropdownFlags();
dropdownLinks();
startSearchOnChange();
// Fereme le dropdown si on clique autre part que sur le bouton
window.onclick = function(event) {
    if (!event.target.matches('.btn-flag') && !event.target.matches('.btn-img')&& !event.target.matches('.btn-flag-fr')
        && !event.target.matches('.btn-img-fr') && !event.target.matches('.btn-flag-fr') && !event.target.matches('.btn-img-fr')) {
        const flagDropdown = document.querySelector('div.dropdown-flags');
        flagDropdown.style.display = "none";

    }

    if(!event.target.matches('.with-dropdown') && !event.target.matches('.btn-dropdown')&& !event.target.matches('.material-symbols-outlined')){
        const linkWithDropDown = document.querySelector('div.with-dropdown');
        linkWithDropDown.style.display = "none";

    }
}