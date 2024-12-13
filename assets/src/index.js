import "./iconedSelect.scss";
import "./ui.scss";
import Choices from "choices.js";
import "choices.js/public/assets/styles/choices.css";

document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.iconedSelect select').forEach(iconedSelect=>{
        const arrOptions=[]

        iconedSelect.querySelectorAll('option').forEach(iconedOption=>{
            const label = iconedOption.innerHTML.replace(/\[((.)*)\]/, "<span>[$1]</span>", iconedOption.innerHTML)

            arrOptions.push({
                value: iconedOption.value,
                label: iconedOption.dataset.icon ? `<img src="${iconedOption.dataset.icon}"/> ${label}` : label,
                id: iconedOption.value,
                selected: iconedSelect.value == iconedOption.value,
            })
        })

        const choices = new Choices(iconedSelect, {
            choices: arrOptions,
            allowHTML: true,
            itemSelectText: ''
        })
    })
})