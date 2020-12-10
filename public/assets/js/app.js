//essa função acaba por ter seu contexto global, assim como as variáveis de identificação aqui usadas também,
//ou seja, ela afeta a aplicação como um todo e isso por gerar transtornos, por exemplo, se tiver outro menu-toggle etc.
//Por causa disso, vamos criar uma função autoinvocada e restringir o contexto dessas variáveis a função e não ao contexto global.
//lembrar do contexto de escopo das funções, onde suas variáveis permanecem no limite das funções.
(function () {
    const menuToggle = document.querySelector(".menu-toggle"); //definindo como constante o elemento
    menuToggle.onclick = function (e) {
        //definindo que quando clickado nesse elemento vai executar a função
        const body = document.querySelector("body"); //definindo a constante
        body.classList.toggle("hide-sidebar"); //definindo que nessa constante vamos atribuir uma class hide-sidebar qndo não houver e retirar quando houver
    };
})();
