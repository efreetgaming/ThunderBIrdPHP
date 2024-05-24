document.addEventListener('DOMContentLoaded', () => {
    const countries = document.querySelector("#country");

    fetch(`https://restcountries.com/v2/all`).then(res => {
        return res.json();
    }).then(data => {
        let output = ""
        data.forEach(country => {
            // console.log(country.name)
            if (country.name === "Philippines") {
                output += `<option value="${country.name}" selected>${country.name}</option>`
            } else {
                output += `<option value="${country.name}">${country.name}</option>`
            }
        });
        countries.innerHTML = output

    }).catch(err => {
        console.log(err)
    })

});