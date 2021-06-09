
const count = 0;
const step = 0;
let n = 0;

while (n < count) {
  const info = document.createElement('p');
  info.textContent('Добавляем элементы... ');
  board.append(info);
  fetch(`./iblock_add.php/?count=${count}`).then(() => info.append(`добавлено ${step} элементов`));
  n += step;
}