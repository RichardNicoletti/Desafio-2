document.addEventListener('DOMContentLoaded', function () {
  const addressForm = document.querySelector("#address-form");
  const cepInput = document.querySelector("#cep");
  const addressInput = document.querySelector("#endereco");
  const cityInput = document.querySelector("#cidade");
  const neighborhoodInput = document.querySelector("#bairro");
  const regionInput = document.querySelector("#uf");
  const formInputs = document.querySelectorAll("[data-input]");
  const closeButton = document.querySelector("#close-message");

  cepInput.addEventListener("keypress", (e) => {
      const onlyNumbers = /[0-9]|\./;
      const key = String.fromCharCode(e.keyCode);

      if (!onlyNumbers.test(key)) {
          e.preventDefault();
          return;
      }
  });

  cepInput.addEventListener("keyup", (e) => {
      const inputValue = e.target.value;

      if (inputValue.length === 8) {
          localStorage.setItem('cep', inputValue);
          getAddress(inputValue);
      }
  });

  const getAddress = async (cep) => {
      toggleLoader();

      cepInput.blur();

      const apiUrl = `https://viacep.com.br/ws/${cep}/json/`;

      try {
          const response = await fetch(apiUrl);
          const data = await response.json();

          if (data.erro) {
              if (!addressInput.hasAttribute("disabled")) {
                  toggleDisabled();
              }

              addressForm.reset();
              toggleLoader();
              toggleMessage("CEP Inválido, tente novamente.");
              return;
          }

          if (addressInput.value === "") {
              toggleDisabled();
          }

          addressInput.value = data.logradouro;
          cityInput.value = data.localidade;
          neighborhoodInput.value = data.bairro;
          regionInput.value = data.uf;
      } catch (error) {
          console.error("Erro ao buscar o CEP:", error);
      } finally {
          toggleLoader();
      }
  };

  const toggleDisabled = () => {
      if (regionInput.hasAttribute("disabled")) {
          formInputs.forEach((input) => {
              //input.removeAttribute("disabled"); //Richard
          });
      } else {
          formInputs.forEach((input) => {
              //input.setAttribute("disabled", "disabled"); //Richard
          });
      }
  };

  const toggleLoader = () => {
      const fadeElement = document.querySelector("#fade");
      const loaderElement = document.querySelector("#loader");

      fadeElement.classList.toggle("hide");
      loaderElement.classList.toggle("hide");
  };

  const toggleMessage = (msg) => {
      const messageElement = document.querySelector("#message");
      const messageTextElement = document.querySelector("#message p");

      messageTextElement.innerText = msg;
      messageElement.classList.toggle("hide");
      fadeElement.classList.toggle("hide");
  };

  closeButton.addEventListener("click", () => toggleMessage());
});
