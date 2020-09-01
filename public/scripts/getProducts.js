$(document).ready(function () {

   getProducts();

})

let totalPrice    = 0;
let totalQuantity = 0;
let hit           = 0;
let taxLow        = 0;
let taxHigh       = 0;
let orderPrice    = 0;
let counter       = 0;
let products      = [];
let order         = [];
var choice        = true;

function getProducts() {
   $.ajax({
         type: 'GET',
         url: "/testing/testsmitenvoogt/application/main.php",
         headers: {
            'Authorization': 'Bearer ' + $('.csrf_token').val(),
            'tokenType'    : 'clientToken',
            'switchkey'    : 'getproducts'
         },
         async       : true,
         contentType : "application/json"
      })
      .done(function (data) {
         if (data === "220") {
            $(".no-products-modal").show()
         }
         // let productss = JSON.parse(data)
         // createProducts(productss);
         console.log(data);
      })
      .fail(function () {
         alert("getproducts failed");
      })
}

class Product {
   constructor(id, name, quantity, unit, price, takeAway, siteMessage, category, taxCategory, itemQuantity, totalItemPrice) {
      this.id           = id;
      this.name         = name;
      this.quantity     = quantity;
      this.unit         = unit
      this.price        = parseFloat(price);
      this.takeAway     = takeAway;
      this.siteMessage  = siteMessage;
      this.category     = category;
      this.taxCategory  = taxCategory
      this.itemQuantity = itemQuantity;
      this.totalItemPrice = parseFloat(totalItemPrice);
      products.push(this);
   }
}

function getTime() {
   let time       = new Date();
   let now        = new Date();
   let startTime  = '10:35';
   let endTime    = '21:05';
   let startDate  = new Date(time.getTime());
   let endDate    = new Date(time.getTime());

   startDate.setHours(startTime.split(":")[0]);
   startDate.setMinutes(startTime.split(":")[1]);

   endDate.setHours(endTime.split(":")[0]);
   endDate.setMinutes(endTime.split(":")[1]);

   if (now > startDate && now < endDate) {
      now.setMinutes(now.getMinutes() + 30); // timestamp
      now = new Date(now); // Date object

      return now;
   } else {
      let defDate = new Date();
      let minTime = "11:00";
      let defTime = new Date(defDate.getTime())
      defTime.setHours(minTime.split(":")[0]);
      defTime.setMinutes(minTime.split(":")[1]);
      return defTime;
   }
}

function setCalender() {
   let lunch   = 0;
   let minTime = getTime()
   let maxTime;
   let minDate;
   let maxDate;
   let noCalendar;

   for (var b = 0; b < order.length; b++) {
      if (order[b].category === "lunch") {
         lunch++;
      }
   }

   flatpickr.localize(flatpickr.l10ns.nl);

   if (choice == false) {
      minDate = new Date().fp_incr(1);
      maxDate = new Date().fp_incr(14);
      noCalendar = "";
   } else {
      minDate = "";
      maxDate = "";
      noCalendar = true;
   }

   if (lunch > 0) {
      maxTime = "15:30";
   } else {
      maxTime = "21:10";
   }

   flatpickr(".date", {
      enableTime: true,
      disableMobile: "true",
      minTime: minTime,
      maxTime: maxTime,
      defaultDate: minTime,
      time_24hr: true,
      minDate: minDate,
      maxDate: maxDate,
      locale: {
         firstDayOfWeek: 1
      },
      noCalendar: noCalendar,
      altInput: true,
      altFormat: "j F H:i",
      dateFormat: "Y-m-d H:i"
   })

}

function euroFormatter(num) {
   var formatter = new Intl.NumberFormat('nl-NL', {
      style: 'currency',
      currency: 'EUR',
   });
   return formatter.format(num);
}

function placeProducts(num) {
   let count = 0;
   let message;

   products.forEach(function (item) {

   if (choice == true) { // order is placed today
      let now           = new Date();
      let newDay        = new Date();
      let endDay        = new Date();
      let startOrdering = new Date();
      let endLunch      = new Date();
      let endOrdering   = new Date();
      newDay.setHours(0, 0, 0);
      endDay.setHours(23, 59, 59);
      startOrdering.setHours(10, 35, 0);
      endLunch.setHours(15, 35, 0);
      endOrdering.setHours(21, 5, 0);


      if (now >= newDay && now < startOrdering) {
         message = "available";
         $(".landingtext").html('U kunt vanaf 11:00uur weer bij ons afhalen.')
      } else if (now >= startOrdering && now <= endLunch && item.category === 'lunch') {
         message = "available";
      } else if (now > endLunch && now <= endOrdering && item.category === 'lunch') {
         message = "not-available";
      } else if (now >= startOrdering && now <= endOrdering && item.category !== 'lunch') {
         message = "available";
      } else {
         message = "soon";
         $(".landingtext").html('<span class="alert">Let op! U kunt op dit moment alleen bestellen voor morgen of daarna.</span>')
      }
   } else if (choice == false) {
      message = '';
   }

   

      let template = `
       <div class="orderitemcontainer ${message}" id="${count}">
         <div class="rowcontainer ${item.category}">
         
           <span class="itemname">${item.name}</span>
           <span class="extraaddition-1"> ${item.quantity} ${item.unit}</span>
           <br>
           <span class="extraaddition-2"> ${item.quantity} ${item.unit}</span>
           <span class="extra-break"><br/></span>
           <span class="site-message">${item.siteMessage}</span>
       
         </div>
       
         <div class="last-elements">
       
           <div class="itemprice first-item-price">${euroFormatter(item.price)}</div>
         
           <div class="last-three-elements">
               <button class="subitem-btn" id="${count}"><p>-</p></button>
               <button class="itemquantity" id="itemquantity-${count}"><p>${item.itemQuantity}</p></button>
               <button class="additem-btn" id="${count}"><p>+</p></button>
           </div>
 
           <div class="itemprice last-item-price">${euroFormatter(item.price)}</div>
 
         </div>
     
       </div>  
           `

      if (item.category === "lunch") {
         $(".lunch-header").after(template);
      }
      if (item.category === "warme dranken") {
         $(".warme-dranken-header").after(template);
      }
      if (item.category === "koude dranken") {
         $(".koude-dranken-header").after(template);
      }
      if (item.category === "borrel") {
         $(".borrel-header").after(template);
      }
      if (item.category === "bier") {
         $(".bier-header").after(template);
      }
      if (item.category === "wijn") {
         $(".wijn-header").after(template);
      }
      if (item.category === "gebak") {
         $(".gebak-header").after(template);
      }

      count++;
      message = '';
   })
   changeQuantity();
}

function createProducts(data) {
   for (var x = 0; x < data.length; x++) {
      data[x] = new Product(data[x].product_id, data[x].product_name, data[x].quantity, data[x].unit, data[x].price, data[x].take_away, data[x].site_message, data[x].category, data[x].tax_category, 0, 0)
   }
   placeProducts();
}

function changeQuantity() {
   $(".additem-btn").on('click',
      (e) => {

         let now = new Date
         let endDay = new Date();
         endDay.setHours(21, 5, 0);
         if (now > endDay && choice === true) {
            alert("Het is inmiddels ná 21:00 uur. U kunt voor vandaag geen bestellingen meer plaatsen.");
            return
         }

         let id = e.currentTarget.id;

         if (products[id].category === "lunch" && products[id].itemQuantity < 1) {
            $(".lunch-modal").toggle();
         }

         if (products[id].itemQuantity > 9) {
            return
         }
         if (products[id].category === 'gebak' && products[id].itemQuantity > 5) {
            return
         };
         if (products[id].category === 'borrel' && products[id].itemQuantity > 7) {
            return
         };
         if (products[id].category === 'lunch' && products[id].itemQuantity > 2) {
            return
         };
         if (products[id].category === 'wijn' && products[id].itemQUantity > 2) {
            return
         };
         if (products[id].name === 'Bittergarnituur' && products[id].itemQuantity > 3) {
            return
         };
         if (products[id].name === 'Bittergarnituur (vega)' && products[id].itemQuantity > 3) {
            return
         };

         $("#itemprice_" + id).addClass('ordered');
         products[id].itemQuantity += 1;
         totalQuantity += 1;
         products[id].totalItemPrice += parseFloat(products[id].price);
         totalPrice += parseFloat(products[id].price);

         $("#itemquantity-" + id).html(`<p>${products[id].itemQuantity}</p>`);
         $("#itemquantity-" + id).css('background-color', 'rgb(53, 202, 53)').css('color', 'white');
         $(".numofitems").text(`${totalQuantity} items`)
         $(".totalprice").text(euroFormatter(totalPrice));
         $("#itemprice_" + id).text(euroFormatter(products[id].itemQuantity * products[id].price))
      })

   $('.subitem-btn').on('click',
      (e) => {
         let id = e.currentTarget.id;

         if (products[id].itemQuantity === 0) {
            return;
         }

         products[id].itemQuantity -= 1;
         totalQuantity -= 1;
         products[id].totalItemPrice -= parseFloat(products[id].price);
         totalPrice -= parseFloat(products[id].price);

         $("#itemquantity-" + id).html(`<p>${products[id].itemQuantity}</p>`);
         $(".numofitems").text(`${totalQuantity} items`);
         $(".totalprice").text(euroFormatter(totalPrice));
         $("#itemprice_" + id).text(euroFormatter(products[id].itemQuantity * products[id].price))

         if (products[id].itemQuantity === 0) {
            $("#itemquantity-"   + id).css('background-color', 'rgb(187, 180, 167)').css('color', '#483431');
            $("#itemprice_"      + id).removeClass('ordered');
            $("#itemprice_"      + id).html(`<p>${euroFormatter(products[id].price)}</p>`);
         }
      })
}

$(".vandaag").on('click',
   () => {
      if (choice == true) {
         return;
      }
      choice = !choice;

      $(".lunch-modal").hide();
      products.forEach((item) => {
         item.itemQuantity   = 0;
         item.totalItemPrice = 0;
      })
      $(".vandaag").addClass("chosen");
      $(".toekomst").removeClass("chosen");
      $(".orderitemcontainer").remove();
      $(".check").css('display', 'none');

      totalPrice     = 0;
      totalQuantity  = 0;
      hit            = 0;
      order          = [];
      taxLow         = 0;
      orderPrice     = 0;
      taxHigh        = 0;
      orderPrice     = 0;
      counter        = 0;

      placeProducts();
   })

$(".toekomst").on('click',
   () => {
      if (choice == false) {
         return;
      }
      choice = !choice;
      $(".lunch-modal").hide();
      products.forEach((item) => {
         item.itemQuantity = 0;
         item.totalItemPrice = 0;
      })
      $(".vandaag").removeClass("chosen");
      $(".toekomst").addClass("chosen");
      $(".orderitemcontainer").remove();
      $(".check").css('display', 'none');

      totalPrice     = 0;
      totalQuantity  = 0;
      hit            = 0;
      order          = [];
      taxLow         = 0;
      orderPrice     = 0;
      taxHigh        = 0;
      orderPrice     = 0;
      counter        = 0;

      placeProducts();
   })

$(".exit p").on('click',
   () => {
      $(".lunch-modal").toggle();
   })

$(".go-back").on('click',
   (e) => {
      e.preventDefault();
      hit         = 0;
      order       = [];
      taxLow      = 0;
      taxHigh     = 0;
      orderPrice  = 0;

      $(".check-items-container").empty();
      $(".check").css('display', 'none');
   })

$(".orderbtn").on('click',
   () => {

      $(".lunch-modal").hide();

      if (totalQuantity === 0 || hit > 0) {
         return;
      }

      for (let y = 0; y < products.length; y++) {
         if (products[y].itemQuantity > 0) {

            if (products[y].taxCategory == 9) {
               taxLow += ((products[y].price * products[y].itemQuantity) * .09)
            }

            if (products[y].taxCategory == 21) {
               taxHigh += ((products[y].price * products[y].itemQuantity) * .21)
            }

            $(".check-items-container").append(
               `<div class="check-items item_${counter}">
           <div class="item-final-quantity">${products[y].itemQuantity} x </div>
           <div class="item-final-name">${products[y].name} ${products[y].quantity} ${products[y].unit}</div>
           <div class="item-final-price">${euroFormatter(products[y].totalItemPrice)}</div></div>`
            );

            // $(".form").append(`<input type="hidden" name="json-order" value="<?php echo $output ?>" />`).append()

            order.push(products[y]);
            orderPrice += (products[y].price * products[y].itemQuantity);
            counter++;
            hit++

            $(".tax-low").text(`BTW 9%: ${euroFormatter(taxLow)}`);
            $(".tax-high").text(`BTW 21%: ${euroFormatter(taxHigh)}`);
            $(".price").text(`TOTAAL (inc btw): ${euroFormatter(orderPrice)}`);
            $(".check").css('display', 'block');

            setCalender();
         }
      }
   })


function validatePhoneNumber(phone) {
   const regex = /^((\+|00(\s|\s?\-\s?)?)31(\s|\s?\-\s?)?(\(0\)[\-\s]?)?|0)[1-9]((\s|\s?\-\s?)?[0-9])((\s|\s?-\s?)?[0-9])((\s|\s?-\s?)?[0-9])\s?[0-9]\s?[0-9]\s?[0-9]\s?[0-9]\s?[0-9]$/;
   regex.test(phone)
}

function validateEmail(email) {
   const regex = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
   regex.test(email);
}    
    


$(".submit-btn").on('click',
   (event) => {
      event.preventDefault();

      if($(".name").val == '' || $(".email").val() == "" || $(".phone").val() == "" || $(".date").val() == "") {
        alert("vul alstublieft de verplichte (*) velden in");
        return;
      }

      let pickUpTimeInput  = $(".date").val()
      let pickUpTime       = `${pickUpTimeInput}:00`;
      let userFirstName    = $(".firstname").val();
      let userPrefix       = $(".prefix").val();
      let userLastName     = $(".lastname").val();
      let userPhone        = $(".phone").val();
      let userEmail        = $(".email").val();
      let userText         = $(".text-area").val();

      if(validatePhoneNumber(userPhone) === false){
         alert('ongeldig telefoonnummer');
         return;
      };

      if(validateEmail(userEmail) === false){
         alert('ongeldig emailadres');
         return;
      };


      order.unshift(pickUpTime, userFirstName, userPrefix, userLastName, userPhone, userEmail, userText, orderPrice, taxLow, taxHigh);

      let orderToPlace = JSON.stringify(order)

      $.post('/testing/testsmitenvoogt/application/main.php', {
               'Authorization': 'Bearer ' + $('.csrf_token').val(),
               'switchkey'    : 'placeorder',
               'tokenType'    : 'clientToken',
               'order'        : orderToPlace,
               'email'        : userEmail
            },function (data) {
            console.log(data);
            // if(data == "0"){
            //   alert("uw bestelling moet verder dan 30 minuten in de toekomst liggen");
            //   return;
            // }
         })

      order          = [];
      products       = [];
      counter        = 0;
      hit            = 0;
      orderPrice     = 0;
      totalPrice     = 0;
      totalQuantity  = 0;
      taxHigh        = 0;
      taxLow         = 0;

      $(".orderitemcontainer").remove();
      $(".check-items-container").empty();
      $(".check").css('display', 'none');
      $(".maincontent").hide()
      $(".ordered-modal").show();

   })

$(".privacy").on('click',
   function () {
      $(".privacy-modal").show("fast");
      $(".check").hide("fast");
   })

$(".close-privacy-modal").on('click',
   function () {
      $(".privacy-modal").hide("fast");
      $(".check").show("");
   })