export default () => {
  const sticky = document.querySelector('#header-sticky');
  const header = document.querySelector('#header').getBoundingClientRect();
  const headerClass = 'header--is-visible';
  const h = Math.ceil(header.height);

  window.addEventListener('scroll', () => {
    const pos = window.scrollY;

    if (pos > h * 2) {
      sticky.classList.add(headerClass);
    } else {
      sticky.classList.remove(headerClass);
    }
  });
};
