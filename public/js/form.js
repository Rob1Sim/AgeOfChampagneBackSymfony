
let formulaire;

let input;



input = document.getElementById("Carte_contenuImage_file");

input.accept = "image/png, image/jpeg"

formulaire = document.querySelector('form[id="new-Carte-form"]');




input.addEventListener("change",(event)=>{
    const image = document.getElementById("Carte_contenuImage_file").files[0];

    if (image.type !== "image/png" && image.type !== "image/jpeg"){
        document.getElementsByClassName("flex-fill")[8].innerHTML +=
            "<span style='color: red' id='error-message'>Le type du fichier n'est pas accepté</span>";
        // On désactive les boutons de submissions
        document.querySelectorAll("button[type='submit']")[0].disabled = true;
        document.querySelectorAll("button[type='submit']")[1].disabled = true;
    }else{
        document.getElementById("error-message").innerHTML =""
        // On active les boutons de submissions
        document.querySelectorAll("button[type='submit']")[0].disabled = false;
        document.querySelectorAll("button[type='submit']")[1].disabled = false;
    }
})





