import Cookies from 'js-cookie';
const cookiesBox = document.querySelector('#cookies');
const cookiesBtn = document.querySelector('#cookies-button');
const cookiesClass = 'cookies--is-show';

export default () => {
  if (!Cookies.get('cookies-policy')) {
    cookiesBox.classList.add(cookiesClass);
  }

  cookiesBtn.addEventListener('click', () => {
    cookiesBox.classList.remove(cookiesClass);
    Cookies.set('cookies-policy', 1, { expires: 365 });
  });
};
