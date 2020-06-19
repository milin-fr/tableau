var app = {
    init: function() {
          document.querySelector("#axios-form--test").addEventListener("submit", app.onClickBtn);
    },
    onClickBtn: function(event) {
      event.preventDefault();
      const url = this.action;

      //axios.get(url).then(function(response){
      //  console.log(response);
      //});
      console.log(this.querySelector("#description").value);
      axios.put(url, {
        "project_description": this.querySelector("#description").value
      })
      .then(function (response) {
        console.log(response);
      })
      .catch(function (error) {
        console.log(error);
      });
    }
  };
  
document.addEventListener('DOMContentLoaded', app.init);
