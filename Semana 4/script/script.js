

function openModal(cupcake) {
    var txt1 = document.getElementById("txt1");
    var txt2 = document.getElementById("txt2");
    var txt3 = document.getElementById("txt3");
    switch(cupcake) {
        case "CupFlavor1":
            txt1.innerHTML = "Cookies And Cream";
            txt2.innerHTML = "Creme de Negresco no bolo de chocolate";
            txt3.innerHTML = "R$15,00";
            break;

        case "CupFlavor2":
            txt1.innerHTML = "Red Velvet";
            txt2.innerHTML = "Recheio de creme de morango";
            txt3.innerHTML = "R$15,00";
            break;

        case "CupFlavor3":
            txt1.innerHTML = "Rainbow Vanilla";
            txt2.innerHTML = "Creme de baunilha";
            txt3.innerHTML = "R$15,00";
            break;
        
        case "CupFlavor4":
            txt1.innerHTML = "Mint Chocolate";
            txt2.innerHTML = "Toque de menta com chocolate";
            txt3.innerHTML = "R$15,00";
            break;

        case "CupFlavor5":
            txt1.innerHTML = "Raspberry Chocolate";
            txt2.innerHTML = "Recheio de leite condensado com raspberrys silvestres";
            txt3.innerHTML = "R$15,00";
            break;

        case "CupFlavor6":
            txt1.innerHTML = "Double Chocolate";
            txt2.innerHTML = "Bolo de chocolate com recheio de chocolate";
            txt3.innerHTML = "R$15,00";
            break;
      default:
            txt1.innerHTML  = "Delicioso cupkake.";   
            txt2.innerHTML  = "Esolha seu sabor preferido!";
            txt3.innerHTML  = "Preço nos detalhes de cada um.";
    }
    document.getElementById("knowMore").style.display = "inline-block";    
}

function closeModal() {
    document.getElementById("knowMore").style.display = "none";
}
