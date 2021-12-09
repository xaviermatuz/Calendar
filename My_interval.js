// Function to hide the URL's in the table
function myinterval() {
  console.log("INDEX SCRIPT MY INTERVAL");
  const class_div_container = document.querySelector(".fc-view");
  if (class_div_container.classList.contains("fc-daygrid")) {
    try {
      setTimeout(function () {
        console.log("--HIDEURL DAYGRID-----ENTRA A INDEX HIDEURL|||||||||");
        let anchorclass = document.getElementsByClassName("fc-daygrid-event");
        for (var en = 0; en < anchorclass.length; en++) {
          if (anchorclass[en].href != "" && anchorclass[en].href != null) {
            anchorclass[en].setAttribute("hiddenhref", anchorclass[en].href);
            anchorclass[en].removeAttribute("href");
          }
        }
        for (let index = 0; index < mas.length; index++) {
          mas[index].setAttribute(
            "id",
            "pop"
          ); /* Set the id to more link in table */
          console.log(mas[index]);
        }
        if (document.getElementById("pop") != null) {
          document.getElementById("pop").onclick = popinterval;
        } else {
          //CARRY ON NOTHING TO DO HERE
        }
      }, 13);
    } catch (err) {
      console.log(err.message);
    }
  } else if (class_div_container.classList.contains("fc-timegrid")) {
    setTimeout(function () {
      console.log("--HIDEURL DAYGRID-----ENTRA A INDEX HIDEURL|||||||||");
      let anchorclass = document.getElementsByClassName("fc-daygrid-event");
      for (var en = 0; en < anchorclass.length; en++) {
        if (anchorclass[en].href != "" && anchorclass[en].href != null) {
          anchorclass[en].setAttribute("hiddenhref", anchorclass[en].href);
          //anchorclass[en].removeAttribute("href");
          anchorclass[en].setAttribute("href", "");
        }
      }
    }, 15);
  } else {
    console.log("--HIDEURL LIST-----ESTA LLAMANDO HIDEURL EVENT");
    let listanchorclass = document.getElementsByClassName(
      "fc-event-forced-url"
    );
    setTimeout(function () {
      for (let en = 0; en < listanchorclass.length; en++) {
        listanchorclass[en].children[2].children[0].setAttribute(
          "hiddenhref",
          listanchorclass[en].children[2].children[0].getAttribute("href")
        );
        listanchorclass[en].children[2].children[0].removeAttribute("href");
      }
    }, 13);
  }
}
//FOR THE POPOVER IN DAYVIEW (MONTH)
function popinterval() {
  console.log("LLAMA POP");
  let anchor_Handler_pop = document.getElementsByClassName("fc-daygrid-event");
  setTimeout(function () {
    console.log("--INDEX HIDEURL POPOVER-----ENTRA A INDEX HIDEURL|||||||||");
    for (var en = 0; en < anchor_Handler_pop.length; en++) {
      if (
        anchor_Handler_pop[en].href != "" &&
        anchor_Handler_pop[en].href != null
      ) {
        anchor_Handler_pop[en].setAttribute(
          "hiddenhref",
          anchor_Handler_pop[en].href
        );
        anchor_Handler_pop[en].removeAttribute("href");
      }
    }
  }, 15);
}
