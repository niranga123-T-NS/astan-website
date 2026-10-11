// Website admin helpers
(function () {
  // Confirm before destructive actions
  document.querySelectorAll('form[data-confirm]').forEach(function (f) {
    f.addEventListener('submit', function (ev) {
      if (!confirm(f.getAttribute('data-confirm'))) ev.preventDefault();
    });
  });

  var form = document.querySelector('form[data-resize]');
  if (!form) return;
  var input = form.querySelector('[data-photos]');
  var list = form.querySelector('[data-photo-list]');
  var status = form.querySelector('[data-status]');
  var save = form.querySelector('[data-save]');

  input.addEventListener('change', function () {
    var n = input.files.length;
    list.textContent = n ? n + ' photo' + (n > 1 ? 's' : '') + ' selected: ' +
      Array.prototype.map.call(input.files, function (f) { return f.name; }).join(', ') : '';
  });

  // Shrink large photos in the browser before uploading (faster uploads on mobile data).
  var MAX = 2400;
  function shrink(file) {
    return new Promise(function (resolve) {
      if (!/^image\/(jpeg|png|webp)$/.test(file.type) || !window.createImageBitmap) return resolve(file);
      createImageBitmap(file, { imageOrientation: 'from-image' }).then(function (bmp) {
        var scale = Math.min(1, MAX / Math.max(bmp.width, bmp.height));
        if (scale === 1 && file.size < 3 * 1024 * 1024) return resolve(file);
        var c = document.createElement('canvas');
        c.width = Math.round(bmp.width * scale);
        c.height = Math.round(bmp.height * scale);
        var ctx = c.getContext('2d');
        ctx.fillStyle = '#fff';
        ctx.fillRect(0, 0, c.width, c.height);
        ctx.drawImage(bmp, 0, 0, c.width, c.height);
        c.toBlob(function (blob) {
          if (!blob || blob.size >= file.size) return resolve(file);
          resolve(new File([blob], file.name.replace(/\.\w+$/, '') + '.jpg', { type: 'image/jpeg' }));
        }, 'image/jpeg', 0.9);
      }).catch(function () { resolve(file); });
    });
  }

  var busy = false;
  form.addEventListener('submit', function (ev) {
    if (busy || !input.files.length || !window.DataTransfer) {
      save.disabled = true;
      status.textContent = 'Saving…';
      return;
    }
    ev.preventDefault();
    busy = true;
    save.disabled = true;
    status.textContent = 'Preparing photos…';
    Promise.all(Array.prototype.map.call(input.files, shrink)).then(function (files) {
      var dt = new DataTransfer();
      files.forEach(function (f) { dt.items.add(f); });
      input.files = dt.files;
      status.textContent = 'Uploading ' + files.length + ' photo(s)…';
      form.submit();
    });
  });
})();
