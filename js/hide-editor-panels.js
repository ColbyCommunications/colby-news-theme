const hideEditorPanel = (panelTitle, postType = 'all') => {
  if (
    !postType ||
    postType === 'all' ||
    document.querySelector('body').classList.contains(`post-type-${postType}`)
  ) {
    const observer = new MutationObserver(function (mutations_list) {
      mutations_list.forEach(function (mutation) {
        mutation.addedNodes.forEach(function (added_node) {
          let nodeType = Object.prototype.toString.call(added_node);
          if (nodeType === '[object HTMLDivElement]') {
            if (added_node.classList.contains('components-panel__body')) {
              if (added_node.textContent.startsWith(panelTitle)) {
                added_node.classList.add('hidden');
                observer.disconnect();
              }
            }
          }
        });
      });
    });

    observer.observe(document.querySelector('#editor'), {
      subtree: true,
      childList: true,
    });
  }
};

const hideEditorPanels = () => {
  hideEditorPanel('Featured image', 'post');
};

document.addEventListener('DOMContentLoaded', hideEditorPanels);
