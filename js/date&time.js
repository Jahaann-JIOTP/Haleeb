
// time
let minutes = 0.00001;

function step() {

    let t = new Date(new Date().getTime() + minutes * 60000);
    p.innerHTML = t.getHours() + ":" + t.getMinutes() + ":" + t.getSeconds();
    window.requestAnimationFrame(step);

}

window.requestAnimationFrame(step);
// Date
var myDate = new Date();

var myMonths = ["January ", "February ", "March ", "April ", "May ", "June ", "July ", "August ", "September ",
    "October ", "November ", "December "
];



document.getElementById("display").innerHTML = myMonths[myDate.getMonth()] + myDate.getDate() + "th, " + myDate
    .getFullYear();





//this uses the number 4 because it's currently april, then finds the 4th string in the array.


// date.toDateString()

// Theme
console.clear();

//get system preference
let displayDarkTheme = window.matchMedia('(prefers-color-scheme: dark)').matches;
document.documentElement.dataset.theme = displayDarkTheme ? "dark" : "light";

const themeSwitchBtn = document.getElementById("theme-switcher");
let timeout;

// delay background and color change
const style = document.createElement('style');
style.innerHTML = "* {transition: background 100ms 300ms ease-out, color 10ms 100ms ease-out !important;}";

themeSwitchBtn.addEventListener("click", switchTheme)

function switchTheme() {
    displayDarkTheme = !displayDarkTheme;
    document.documentElement.dataset.theme = displayDarkTheme ? "dark" : "light";

    if (timeout) {
        clearTimeout(timeout);
    } else {
        document.head.appendChild(style);
    }
    timeout = setTimeout(() => {
        document.head.removeChild(style);
        timeout = null;
    }, 500)
}

