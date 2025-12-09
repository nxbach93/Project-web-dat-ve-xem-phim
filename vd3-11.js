window.replaceElement = function () {
  const container = document.getElementById('container');
  const btn = container ? container.querySelector('button') : null;
  const img = document.getElementById('image');
  const placeholderId = 'imagePlaceholder';

  if (img) {
    const p = document.createElement('p');
    p.id = placeholderId;
    p.textContent = 'Hình ảnh đã được thay thế bằng đoạn văn bản';
    p.style.color = 'red';
    p.style.fontWeight = '700';
    img.replaceWith(p);
    if (btn) btn.textContent = 'Hiện lại hình ảnh';
    return;
  }

  const p = document.getElementById(placeholderId);
  const imgElem = document.createElement('img');
  imgElem.id = 'image';
  imgElem.src = 'https://cdn-img.thethao247.vn/origin_1920x0/storage/files/haibui/2025/02/05/chrome_fyvigdyoo8-1-67a2d9f682ddd.png';
  imgElem.alt = 'Hình ảnh ban đầu';
  imgElem.style.width = '200px';
  imgElem.style.height = 'auto';

  if (p) p.replaceWith(imgElem);
  else if (container) container.appendChild(imgElem);

  if (btn) btn.textContent = 'Thay thế hình ảnh';
};
