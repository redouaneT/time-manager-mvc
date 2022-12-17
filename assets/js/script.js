window.addEventListener('load', function(){
    const selectCountry = document.querySelector("#country");
    if (selectCountry) {
        selectCountry.addEventListener('change', function(){
            var options = selectCountry.querySelectorAll("option");
            for (const option of options) {
                if (option.selected && option.value != -1) {
                    let optionSelected = parseInt(option.value);
                    let url = "http://localhost/timeManagerMvc/city/selectByForeignKey?id=" + optionSelected + "&&script=true";
                    const xhttp = new XMLHttpRequest();
                    xhttp.addEventListener('load', ()=>{
                        let resultat = JSON.parse(xhttp.responseText);
                        const selectCity = document.querySelector("#city_id");
                        selectCity.disabled = false;
                        console.log(selectCity);
                        let html = "";
                        resultat.forEach(element => {
                            html += `<option value="${element.id}">${element.name}</option>`;
                        });
                        selectCity.innerHTML = html;
                    })
                    xhttp.open("GET", url);
                    xhttp.send();
                }
            }
        })
        if (selectCountry.value !== "-1") {
            var event = new Event('change');
            selectCountry.dispatchEvent(event);
        }
    }
})