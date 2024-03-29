const WPThemeCSS = () =>
  `<style>
  :root {
    --wp-admin-theme-color:#007cba;
    --wp-admin-theme-color-darker-10:#006ba1;
    --wp-admin-theme-color-darker-20:#005a87
   }
   #start-resizable-editor-section {
    display:none
   }
   .wp-block-audio figcaption {
    color:#555;
    font-size:13px;
    text-align:center
   }
   .wp-block-code {
    font-family:Menlo,Consolas,monaco,monospace;
    font-size:.9em;
    color:#1e1e1e;
    padding:.8em 1em;
    border:1px solid #ddd;
    border-radius:4px
   }
   .blocks-gallery-caption,
   .wp-block-embed figcaption,
   .wp-block-image figcaption {
    color:#555;
    font-size:13px;
    text-align:center
   }
   .wp-block-pullquote {
    border-top:4px solid #555;
    border-bottom:4px solid #555;
    margin-bottom:1.75em;
    color:#555
   }
   .wp-block-pullquote__citation,
   .wp-block-pullquote cite,
   .wp-block-pullquote footer {
    color:#555;
    text-transform:uppercase;
    font-size:.8125em;
    font-style:normal
   }
   .wp-block-navigation ul,
   .wp-block-navigation ul li {
    list-style:none
   }
   .wp-block-navigation-link.wp-block-navigation-link {
    margin:0
   }
   .wp-block-quote {
    border-left:.25em solid #000;
    margin:0 0 1.75em;
    padding-left:1em
   }
   .wp-block-quote__citation,
   .wp-block-quote cite,
   .wp-block-quote footer {
    color:#555;
    font-size:.8125em;
    margin-top:1em;
    position:relative;
    font-style:normal
   }
   .wp-block-quote.has-text-align-right {
    border-left:none;
    border-right:.25em solid #000;
    padding-left:0;
    padding-right:1em
   }
   .wp-block-quote.has-text-align-center {
    border:none;
    padding-left:0
   }
   .wp-block-quote.is-large,
   .wp-block-quote.is-style-large {
    border:none
   }
   .wp-block-search .wp-block-search__label {
    font-weight:700
   }
   .wp-block-group.has-background {
    padding:20px 30px;
    margin-top:0;
    margin-bottom:0
   }
   .wp-block-separator {
    border:none;
    border-bottom:2px solid;
    margin-left:auto;
    margin-right:auto;
    opacity:.4
   }
   .wp-block-separator:not(.is-style-wide):not(.is-style-dots) {
    max-width:100px
   }
   .wp-block-separator.has-background:not(.is-style-dots) {
    border-bottom:none;
    height:1px
   }
   .wp-block-separator.has-background:not(.is-style-wide):not(.is-style-dots) {
    height:2px
   }
   .wp-block-table {
    border-collapse:collapse
   }
   .wp-block-table thead {
    border-bottom:3px solid
   }
   .wp-block-table tfoot {
    border-top:3px solid
   }
   .wp-block-table td,
   .wp-block-table th {
    padding:.5em;
    border:1px solid;
    word-break:normal
   }
   .wp-block-table figcaption,
   .wp-block-video figcaption {
    color:#555;
    font-size:13px;
    text-align:center
   }
   .wp-block-template-part.has-background {
    padding:20px 30px;
    margin-top:0;
    margin-bottom:0
   }
   #end-resizable-editor-section {
    display:none
   }
   </style>
   `;

export default WPThemeCSS;
