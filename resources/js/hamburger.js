import { disableBodyScroll, enableBodyScroll } from 'body-scroll-lock';

export default () => {
  const btns = document.querySelectorAll('.hamburger');
  const aside = document.querySelector('#aside');
  const visibleCLass = 'aside--is-visible';

  btns.forEach((el) => {
    el.addEventListener('click', () => {
      btns.forEach((el) => {
        el.classList.toggle('hamburger--is-open');
      });

      aside.classList.toggle(visibleCLass);
      aside.classList.contains(visibleCLass)
        ? disableBodyScroll(aside, { reserveScrollBarGap: true })
        : enableBodyScroll(aside);
    });
  });
};
