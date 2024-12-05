import "./iconedSelect.scss";
import "./ui.scss";
import Choices from "choices.js";
import "choices.js/public/assets/styles/choices.css";

document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.iconedSelect select').forEach(iconedSelect=>{
        const arrOptions=[]
        iconedSelect.querySelectorAll('option').forEach(iconedOption=>{
            arrOptions.push({
                value: iconedOption.value,
                label: `<img src="${iconedOption.dataset.icon}"/> ${iconedOption.innerHTML}`,
                id: iconedOption.value,
                selected: iconedSelect.value == iconedOption.value,
            })
        })

        const choices = new Choices(iconedSelect, {
            choices: arrOptions,
            allowHTML: true
        })
    })
})