const videoPreviewInit = () => {
  jQuery('.video-preview').magnificPopup({
    type: 'iframe',
  });
};

jQuery('document').ready(() => {
  videoPreviewInit();
});
