module.exports = async (page) => {
  await page.evaluate(async () => {
    // Scroll down
    var distance = 200;
    await new Promise((resolve) => {
      var totalHeight = 0;
      var timer = setInterval(() => {
        var scrollHeight = document.body.scrollHeight;
        window.scrollBy(0, distance);
        totalHeight += distance;

        if (totalHeight >= scrollHeight) {
          clearInterval(timer);
          resolve();
        }
      }, 500);
    });

    // Wait for a short time
    await new Promise((resolve) => setTimeout(resolve, 1000));

    // Scroll back to the top
    await new Promise((resolve) => {
      var currentScroll = document.documentElement.scrollTop;
      var timer = setInterval(() => {
        if (currentScroll > 0) {
          window.scrollBy(0, -distance);
          currentScroll -= distance;
        } else {
          clearInterval(timer);
          resolve();
        }
      }, 100);
    });
  });
  await page.waitForTimeout(1000);
};
