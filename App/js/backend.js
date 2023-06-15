// arrumar css
// validacao de email
// comentar codigo

const form = document.getElementById("form");

if (form) {                                                                     // Verifica se o elemento 'form' existe
  form.addEventListener("submit", async (e) => {                                // Adiciona um ouvinte de evento ao formulário
    e.preventDefault();                                                         // Evita que a página seja recarregada ou redirecionada quando o formulário é enviado
                                                                                
    const dadosForm = new FormData(form);                                       // Cria um objeto FormData que coleta os dados do formulário
                                                                                
    const dados = await fetch("dados.php", {                                    // Faz uma requisição usando o método POST e envia os dados do formulário para 'dados.php'
      method: "POST",
      body: dadosForm,
    });

    const resposta = await dados.json();                                        // Converte a resposta da requisição em JSON
    console.log(resposta);

    if (resposta["status"]) {                                                   // Se status da resposta for true segue se não vai pro else
      const alerta = document.createElement("div");
      alerta.classList.add("alerta-sucesso");
      alerta.innerText = resposta["msg"];                                       // Cria a div da classe 'alerta-sucesso' e atribui o valor da propriedade 'msg'
      document.getElementById("alerta-sucesso").appendChild(alerta);            // Conecta 'alerta' ao elemento com o ID 'alerta-sucesso'

      setTimeout(() => {
        alerta.remove();
      }, 3500);
      
    } else {
      const alerta = document.createElement("div");
      alerta.classList.add("alerta-erro");
      alerta.innerText = resposta["msg"];
      document.getElementById("alerta-erro").appendChild(alerta);

      setTimeout(() => {
        alerta.remove();
      }, 3500);
    }
  });
}


/*const form = document.getElementById("form");

if (form){
    form.addEventListener("submit", async (e) => {
        e.preventDefault();
        
        const dadosForm = new FormData(form);

        const dados = await fetch ("dados.php", {
            method: "POST",
            body: dadosForm
        });
        
        const resposta = await dados.json();
        console.log(resposta);

        if (resposta['status']){
            Swal.fire({
                text: resposta['msg'],
                icon: 'success',
                timer: 2500,
                showConfirmButton: false
              });
        }else {
            Swal.fire({
                text: resposta['msg'],
                icon: 'error',
                timer: 2500,
                showConfirmButton: false
              });
        }
    });

}
*/