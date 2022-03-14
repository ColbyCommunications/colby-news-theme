export default ({
  ...args
}) => /* html */ `
  <iframe
    title="The World in HDR in 4K (ULTRA HD)"
    width="1066"
    height="600"
    src=${args.src ? args.src : "https://www.youtube.com/embed/tO01J-M3g0U?feature=oembed"}
    frameborder="0"
    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
    allowfullscreen
  ></iframe>
`;
