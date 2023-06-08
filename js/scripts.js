'use strict';


const toggleHidden = (...fields) => {

  fields.forEach((field) => {

    if (field.hidden === true) {

      field.hidden = false;

    } else {

      field.hidden = true;

    }
  });
};

const labelHidden = (form) => {

  form.addEventListener('focusout', (evt) => {

    const field = evt.target;
    const label = field.nextElementSibling;

    if (field.tagName === 'INPUT' && field.value && label) {

      label.hidden = true;

    } else if (label) {

      label.hidden = false;

    }
  });
};

const toggleDelivery = (elem) => {

  const delivery = elem.querySelector('.js-radio');
  const deliveryYes = elem.querySelector('.shop-page__delivery--yes');
  const deliveryNo = elem.querySelector('.shop-page__delivery--no');
  const fields = deliveryYes.querySelectorAll('.custom-form__input');

  delivery.addEventListener('change', (evt) => {

    if (evt.target.id === 'dev-no') {

      fields.forEach(inp => {
        if (inp.required === true) {
          inp.required = false;
        }
      });


      toggleHidden(deliveryYes, deliveryNo);

      deliveryNo.classList.add('fade');
      setTimeout(() => {
        deliveryNo.classList.remove('fade');
      }, 1000);

    } else {

      fields.forEach(inp => {
        if (inp.required === false) {
          inp.required = true;
        }
      });

      toggleHidden(deliveryYes, deliveryNo);

      deliveryYes.classList.add('fade');
      setTimeout(() => {
        deliveryYes.classList.remove('fade');
      }, 1000);
    }
  });
};

const filterWrapper = document.querySelector('.filter__list');
if (filterWrapper) {

  filterWrapper.addEventListener('click', evt => {

    const filterList = filterWrapper.querySelectorAll('.filter__list-item');

    filterList.forEach(filter => {

      if (filter.classList.contains('active')) {

        filter.classList.remove('active');

      }

    });

    const filter = evt.target;

    filter.classList.add('active');

  });

}

const shopList = document.querySelector('.shop__list');
if (shopList) {

  shopList.addEventListener('click', (evt) => {

    const prod = evt.path || (evt.composedPath && evt.composedPath());

    if (prod.some(pathItem => pathItem.classList && pathItem.classList.contains('shop__item'))) {
      let prodId = ''
      prod.forEach(el=>{

        if( el.getAttribute && el.getAttribute('data-product_id')){
          console.log(el.getAttribute('data-product_id'))
          prodId = el.getAttribute('data-product_id')
        } 
      })
      document.querySelector('#prodId').value = prodId;
      const shopOrder = document.querySelector('.shop-page__order');

      toggleHidden(document.querySelector('.intro'), document.querySelector('.shop'), shopOrder);

      window.scroll(0, 0);

      shopOrder.classList.add('fade');
      setTimeout(() => shopOrder.classList.remove('fade'), 1000);

      const form = shopOrder.querySelector('.custom-form');
      labelHidden(form);

      toggleDelivery(shopOrder);

      const buttonOrder = shopOrder.querySelector('.button');
      const popupEnd = document.querySelector('.shop-page__popup-end');
      buttonOrder.addEventListener('click', (evt) => {
        evt.preventDefault();
        form.noValidate = true;

        const inputs = Array.from(shopOrder.querySelectorAll('INPUT'));

        inputs.forEach(inp => {
          if (checkInputValue(inp)) {
            console.log(inp, 'clearClass')
            if (inp.classList.contains('custom-form__input--error')) {
              inp.classList.remove('custom-form__input--error');
            }

          } else {

            console.log(inp, 'addClass')
            inp.classList.add('custom-form__input--error');

          }
        });

        if (inputs.every(inp => checkInputValue(inp))) {

          evt.preventDefault();
          fetch('http://fashion/forms/orderForm.php', {
            method: 'POST',
            body: new FormData(form)
          })
              .then(response=>response.json())
              .then(json=>{
                if (json.status === 'ok'){
                  toggleHidden(shopOrder, popupEnd);

                  popupEnd.classList.add('fade');
                  setTimeout(() => popupEnd.classList.remove('fade'), 1000);

                  window.scroll(0, 0);

                  const buttonEnd = popupEnd.querySelector('.button');

                  buttonEnd.addEventListener('click', () => {


                    popupEnd.classList.add('fade-reverse');

                    setTimeout(() => {

                      popupEnd.classList.remove('fade-reverse');

                      toggleHidden(popupEnd, document.querySelector('.intro'), document.querySelector('.shop'));

                    }, 1000);

                  },{once:true});
                }
              })
        } else {
          window.scroll(0, 0);

        }
      }, {once:true});
    }
  });
}

const pageOrderList = document.querySelector('.page-order__list');
if (pageOrderList) {

  pageOrderList.addEventListener('click', evt => {


    if (evt.target.classList && evt.target.classList.contains('order-item__toggle')) {
      var path = evt.path || (evt.composedPath && evt.composedPath());
      Array.from(path).forEach(element => {

        if (element.classList && element.classList.contains('page-order__item')) {

          element.classList.toggle('order-item--active');

        }

      });

      evt.target.classList.toggle('order-item__toggle--active');

    }

    if (evt.target.classList && evt.target.classList.contains('order-item__btn')) {

      const status = evt.target.previousElementSibling;
      const newStatus = status.classList && status.classList.contains('order-item__info--no') ? '1': 0;
      const orderId = evt.target.getAttribute('data-order_id');
      fetch(`/forms/toggleOrder.php`, {method: 'POST',body: JSON.stringify({newStatus,orderId})}).then(res=>res.json()).then(res=>{
        if (res.status === 'ok'){
          if (status.classList && status.classList.contains('order-item__info--no')) {
            status.textContent = 'Выполнено';
          } else {
            status.textContent = 'Не выполнено';
          }
          status.classList.toggle('order-item__info--no');
          status.classList.toggle('order-item__info--yes');
        }
      })

    }

  });

}

const checkList = (list, btn) => {

  if (list.children.length === 1) {

    btn.hidden = false;

  } else {
    btn.hidden = true;
  }

};
const addList = document.querySelector('.add-list');
if (addList) {

  const form = document.querySelector('.custom-form');
  labelHidden(form);

  const addButton = addList.querySelector('.add-list__item--add');
  const addInput = addList.querySelector('#product-photo');
  const savedPhoto = addList.querySelector('#savedPhoto');

  if (savedPhoto) {
    savedPhoto.addEventListener('click',(evt)=>{
      addList.removeChild(evt.target);
      document.querySelector('#clearPhoto').checked = true
      addInput.value = '';
      checkList(addList, addButton);
    })
  }

  checkList(addList, addButton);

  addInput.addEventListener('change', evt => {

    const template = document.createElement('LI');
    const img = document.createElement('IMG');

    template.className = 'add-list__item add-list__item--active';
    template.addEventListener('click', evt => {
      addList.removeChild(evt.target);
      addInput.value = '';
      checkList(addList, addButton);
    });

    const file = evt.target.files[0];
    const reader = new FileReader();

    reader.onload = (evt) => {
      img.src = evt.target.result;
      template.appendChild(img);
      addList.appendChild(template);
      checkList(addList, addButton);
    };

    reader.readAsDataURL(file);

  });

  const button = document.querySelector('.button');
  const popupEnd = document.querySelector('.page-add__popup-end');

  button.addEventListener('click', (evt) => {
    evt.preventDefault();
    let fd = new FormData(form)
    if (addList.querySelector('#savedPhoto')){
      fd.append('oldPhoto',1)
    }
    let url = 'http://fashion/forms/productForm.php' + location.search;
    fetch(url, {
       method: 'POST',
       body: fd
    }).then(response=>response.json())
        .then(json=>{
          const endTitle = document.querySelector('.shop-page__end-title')
          if (json.status === 'ok'){
            form.hidden = true;
            popupEnd.hidden = false;
            endTitle.innerHTML = json.text
            window.setTimeout(()=>{
              document.location = '/products'
            }, 2000);
          }
          if (json.status === 'error'){
            form.hidden = true;
            endTitle.innerHTML = json.text
            endTitle.classList.remove('h--icon', 'h--1')
            popupEnd.hidden = false;
            window.setTimeout(()=>{
              form.hidden = false;
              endTitle.classList.add('h--icon', 'h--1')
              popupEnd.hidden = true;
            }, 2000);
          }

        })
  })

}

const productsList = document.querySelector('.page-products__list');
if (productsList) {

  productsList.addEventListener('click', evt => {

    const target = evt.target;

    if (target.classList && target.classList.contains('product-item__delete')) {
      const productId = evt.target.getAttribute('data-product_id');
      fetch(`forms/deleteProduct.php`, {method: 'POST',body: JSON.stringify({productId})}).then(response=>response.json())
          .then(json=>{
            if (json.status === 'ok'){
              productsList.removeChild(target.parentElement);
            }
          })
    }
  });

}

// jquery range maxmin
if (document.querySelector('.shop-page')) {
  const params = new URLSearchParams(document.location.search)
  $('.range__line').slider({
    min: 350,
    max: 32000,
    values: [Number(params.get('priceMin')) || 350, Number(params.get('priceMax')) || 32000],
    range: true,
    create: function(event, ui) {
      $('.min-price').text($('.range__line').slider('values', 0) + ' руб.');
      $('.max-price').text($('.range__line').slider('values', 1) + ' руб.');
      document.querySelector('.priceMin').setAttribute('value', $('.range__line').slider('values', 0))
      document.querySelector('.priceMax').setAttribute('value', $('.range__line').slider('values', 1))
    },
    stop: function(event, ui) {
      $('.min-price').text($('.range__line').slider('values', 0) + ' руб.');
      $('.max-price').text($('.range__line').slider('values', 1) + ' руб.');
      document.querySelector('.priceMin').setAttribute('value', $('.range__line').slider('values', 0))
      document.querySelector('.priceMax').setAttribute('value', $('.range__line').slider('values', 1))
    },
    slide: function(event, ui) {
      $('.min-price').text($('.range__line').slider('values', 0) + ' руб.');
      $('.priceMin').value = $('.range__line').slider('values', 0)
      $('.max-price').text($('.range__line').slider('values', 1) + ' руб.');
      $('.priceMax').value = $('.range__line').slider('values', 1)
    }
  });

}

function checkInputValue(input){
  let valid = false
  let required = input.required
  switch (input.type){
      //text validation
    case 'text': {
      valid = input.value.length < 32
    }
    break
      //phone validation
    case 'tel': {
      valid = Boolean(input.value.match(/^[\+]?[(]?[0-9]{3}[)]?[-\s\.]?[0-9]{3}[-\s\.]?[0-9]{4,6}$/))
    }
    break
      //mail validation
    case 'email': {
      valid = Boolean(input.value.match(/[^@ \t\r\n]+@[^@ \t\r\n]+\.[^@ \t\r\n]+/))
    }
    break
    default : {
      valid = true
    }
  }
  return valid && (required ? input.value.length > 0 : true)
}




