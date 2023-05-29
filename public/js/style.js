let dropdown = document.getElementById("dropdown");
let open1 = document.getElementById("open");
let close1 = document.getElementById("close");

let flag = false;
const dropdownHandler = () => {
  if (!flag) {
    dropdown.classList.add("hidden");
    open1.classList.add("hidden");
    close1.classList.remove("hidden");
    flag = true;
  } else {
    dropdown.classList.remove("hidden");
    close1.classList.add("hidden");
    open1.classList.remove("hidden");
    flag = false;
  }
};
const toggleSubDir = (check) => {
  let subList1 = document.getElementById("sublist1");
  let subList2 = document.getElementById("sublist2");
  let subList3 = document.getElementById("sublist3");
  let subList4 = document.getElementById("sublist4");
  let subList5 = document.getElementById("sublist5");
  let subList6 = document.getElementById("sublist6");
  let subList7 = document.getElementById("sublist7");
  let subList8 = document.getElementById("sublist8");
  let subList9 = document.getElementById("sublist9");
  switch (check) {
    case 1:
      subList9.classList.add("hidden");
      subList8.classList.add("hidden");
      subList7.classList.add("hidden");
      subList6.classList.add("hidden");
      subList5.classList.add("hidden");
      subList4.classList.add("hidden");
      subList3.classList.add("hidden");
      subList2.classList.add("hidden");
      subList1.classList.remove("hidden");
      break;
    case 2:
      subList9.classList.add("hidden");
      subList8.classList.add("hidden");
      subList7.classList.add("hidden");
      subList6.classList.add("hidden");
      subList5.classList.add("hidden");
      subList4.classList.add("hidden");
      subList3.classList.add("hidden");
      subList2.classList.remove("hidden");
      subList1.classList.add("hidden");
      break;
    case 3:
      subList9.classList.add("hidden");
      subList8.classList.add("hidden");
      subList7.classList.add("hidden");
      subList6.classList.add("hidden");
      subList5.classList.add("hidden");
      subList4.classList.add("hidden");
      subList3.classList.remove("hidden");
      subList2.classList.add("hidden");
      subList1.classList.add("hidden");
      break;
    case 4:
      subList9.classList.add("hidden");
      subList8.classList.add("hidden");
      subList7.classList.add("hidden");
      subList6.classList.add("hidden");
      subList5.classList.add("hidden");
      subList4.classList.remove("hidden");
      subList3.classList.add("hidden");
      subList2.classList.add("hidden");
      subList1.classList.add("hidden");
      break;
    case 5:
      subList9.classList.add("hidden");
      subList8.classList.add("hidden");
      subList7.classList.add("hidden");
      subList6.classList.add("hidden");
      subList5.classList.remove("hidden");
      subList4.classList.add("hidden");
      subList3.classList.add("hidden");
      subList2.classList.add("hidden");
      subList1.classList.add("hidden");
      break;
    case 6:
      subList9.classList.add("hidden");
      subList8.classList.add("hidden");
      subList7.classList.add("hidden");
      subList6.classList.remove("hidden");
      subList5.classList.add("hidden");
      subList4.classList.add("hidden");
      subList3.classList.add("hidden");
      subList2.classList.add("hidden");
      subList1.classList.add("hidden");
      break;
    case 7:
      subList9.classList.add("hidden");
      subList8.classList.add("hidden");
      subList7.classList.remove("hidden");
      subList6.classList.add("hidden");
      subList5.classList.add("hidden");
      subList4.classList.add("hidden");
      subList3.classList.add("hidden");
      subList2.classList.add("hidden");
      subList1.classList.add("hidden");
      break;
      case 8:
        subList9.classList.add("hidden");
        subList8.classList.remove("hidden");
        subList7.classList.add("hidden");
        subList6.classList.add("hidden");
        subList5.classList.add("hidden");
        subList4.classList.add("hidden");
        subList3.classList.add("hidden");
        subList2.classList.add("hidden");
        subList1.classList.add("hidden");
        break;
      case 9:
        subList9.classList.remove("hidden");
        subList8.classList.add("hidden");
        subList7.classList.add("hidden");
        subList6.classList.add("hidden");
        subList5.classList.add("hidden");
        subList4.classList.add("hidden");
        subList3.classList.add("hidden");
        subList2.classList.add("hidden");
        subList1.classList.add("hidden");
        break;
  }
};
