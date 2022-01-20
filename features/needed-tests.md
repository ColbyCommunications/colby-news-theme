### Tests needed

The following tests are needed to address all (or at least most)
of the testing requirements listed on the
[WordPress Theme Unit Test](https://make.wordpress.org/themes/handbook/review/theme-unit-test/)
documentation.

## Template Hierarchy Index Pages

[ ] Default index page (`index.php`)
    [ ] Posts are visible
    [ ] Posts display in correct order
    [ ] Correct number of posts display (as per setting in Settings > Reading)
    [ ] Page navigation displays and works correctly
    [ ] Site navigation displays correctly
    [ ] No PHP errors, warnings, or notices
    [ ] No JavaScript errors
[ ] Blog posts index (`home.php`)
    [ ] Posts are visible
    [ ] Posts display in correct order
    [ ] Correct number of posts display (as per setting in Settings > Reading)
    [ ] Page navigation displays and works correctly
    [ ] Site navigation displays correctly
    [ ] No PHP errors, warnings, or notices
    [ ] No JavaScript errors
[ ] Date archives (`archive.php`)
    [ ] Posts are visible
    [ ] Posts display in correct order
    [ ] Correct number of posts display (as per setting in Settings > Reading)
    [ ] Page navigation displays and works correctly
    [ ] Site navigation displays correctly
    [ ] No PHP errors, warnings, or notices
    [ ] No JavaScript errors
[ ] Category archives (`category.php`)
    [ ] Posts are visible
    [ ] Posts display in correct order
    [ ] Correct number of posts display (as per setting in Settings > Reading)
    [ ] Page navigation displays and works correctly
    [ ] Site navigation displays correctly
    [ ] No PHP errors, warnings, or notices
    [ ] No JavaScript errors
[ ] Tag archives (`tag.php`)
    [ ] Posts are visible
    [ ] Posts display in correct order
    [ ] Correct number of posts display (as per setting in Settings > Reading)
    [ ] Page navigation displays and works correctly
    [ ] Site navigation displays correctly
    [ ] No PHP errors, warnings, or notices
    [ ] No JavaScript errors
[ ] Author archives (`author.php`)
    [ ] Posts are visible
    [ ] Posts display in correct order
    [ ] Correct number of posts display (as per setting in Settings > Reading)
    [ ] Page navigation displays and works correctly
    [ ] Site navigation displays correctly
    [ ] No PHP errors, warnings, or notices
    [ ] No JavaScript errors

## Static Front Page

Set Dashboard -> Settings -> Reading to Front Page = Static Page (any static page)

[ ] When at `/`, correct front page displays
[ ] The Blog Posts index page displays properly (`home.php`)
[ ] Site navigation displays correctly
[ ] No PHP errors, warnings, or notices
[ ] No JavaScript errors

## 404 Page

[ ] 404 page displays when page does not exist
[ ] Helpful content is displayed
[ ] Site navigation displays correctly
[ ] No PHP errors, warnings, or notices
[ ] No JavaScript errors

## Search Results

[x] The Search Results page displays properly, with search query results displayed
    [x] Correct number of search results
    [ ] Pagination displays and works correctly
[ ] Site navigation displays correctly
[ ] Debugger returns no PHP errors, warnings, or notices
[ ] The browser reports no JavaScript errors

## Posts displayed on blog posts index

[ ] Interface for filtering by tag and category exists and functions correctly
    (unless not desired for theme)
    [ ] Large numbers of tags or categories should not adversely affect layout
[ ] *Scheduled* posts should *not* display
[ ] *Draft* posts should *not* display
[ ] *Sticky* posts should display at top of the list
[ ] *Sticky* posts should not display a second time in the list
[ ] All post titles should link to full post
[-] "Read more" link displays properly (needs more research - should this be supported?)
[ ] Post formats (Image, Video, Gallery, etc.) display as intended in list view
    [ ] Gallery
    [ ] Image (linked)
    [ ] Image (attached)
    [ ] Video
[ ] *Protected* posts should not display OR should indicate that they are protected
[ ] *Private* posts should only display if the current user has permission to view them
[ ] Post with no body should not adversely impact the layout
[ ] (no title)
    [ ] Lack of post title should not adversely impact layout.
    [ ] Post permalink should be displayed. Making the post date a permalink is
        a great solution. See Twenty Ten for an example.

## Single Posts

[ ] Site navigation displays correctly
[ ] In-page navigation directs to same post (if applicable)
[ ] Post permalink links to page 1
[ ] Test title line height for multiline titles
[ ] Look for potential title overflow issues if the theme has a small title area
[ ] Post with no body does not break layout
[ ] Post with no title does not break layout

## Protected Posts

[ ] Password input form displays properly
[ ] When correct password (secret) is entered, the post and comments are displayed

## Gallery Post Format

[ ] Gallery displays correctly (check for spacing after gallery)
[ ] Gallery image thumbnails link to image post

## Image Post Format

[ ] Image displays as intended in single-post view
[ ] Image does not overflow the content area

## Video Post Format

[ ] Video embeds work.
[ ] Embedded video does not push sidebar(s) below content due to overlap
[ ] `$content_width` should have an appropriate value defined

## Audio Post Format

[ ] Enclosure links work properly

## WYSIWYG Text

[ ] Inherits font family, color, and base font size from global theme
[ ] Paragraphs have correct margins
[ ] Aligned paragraphs are correctly aligned
    [ ] Left
    [ ] Right
    [ ] Center
    [ ] Justified
[ ] H1 - H6 have unique styles
[ ] Blockquote is styled
    [ ] Indented or otherwise distinct from paragraph text
    [ ] If styled with "fancy" background or icon, displays properly with short and long quotes
[ ] Span with style and ASCII characters should display properly
[ ] Tables display as intended
    [ ] `table`
    [ ] `tr`
    [ ] `th`
    [ ] `td`
[ ] Lists styled appropriately (without needing overrides)
    [ ] `ul`
    [ ] `ol`
    [ ] `dl`, `dt`, `dd`
    [ ] Nested lists indented correctly
[ ] Links are styled correctly
    [ ] Correct color
    [ ] At least one other style to distinguish links (underline, background, etc.)
    [ ] The following HTML tags should be styled appropriately to ensure semantic meaning
        of each tag is preserved:
        [ ] `address`
        [ ] `a`
        [ ] `big`
        [ ] `cite`
        [ ] `code`
        [ ] `del`
        [ ] `em`
        [ ] `ins`
        [ ] `kbd`
        [ ] `pre`
        [ ] `q`
        [ ] `s`
        [ ] `strong`
        [ ] `sub`
        [ ] `sup`
        [ ] `tt`
        [ ] `var`

## Images

[ ] Un-Captioned Images
    [ ] Images are aligned properly
        [ ] Center
        [ ] Left
        [ ] Right
        [ ] None
    [ ] Images are offset from surrounding content
    [ ] Images should not have a border unless it’s part of design
[ ] Captioned Images
    [ ] Images are aligned properly
        [ ] Center
        [ ] Left
        [ ] Right
        [ ] None
    [ ] Images are offset from surrounding content
    [ ] Images should not have a border unless it’s part of design
[ ] All floated images are cleared properly
[ ] Wide Images
    [ ] (if resized) Image should display properly, and should be resized as specified
    [ ] Wide image overflows properly (such as using max-width CSS rule or overflow CSS rule)
    [ ] Sidebar must not be pushed below content due to image overlap

## Comments (if not disabled)

[ ] Comments are displayed correctly.
[ ] Threaded comments display correctly.
[ ] Comment pagination displays correctly.
[ ] Author comment is styled (as appropriate).
[ ] User avatars are displayed properly.
[ ] Comment form displays properly for both logged in/logged out users.
[ ] When logged in as admin, edit links are displayed and work correctly.
[ ] HTML is displayed properly in comments, especially lists and block quotes.

## Comments (if disabled)

[ ] Comment form does not display
[ ] "Comments are disabled" notice is displayed

## Pages

[ ] Tags, Categories, and Post date/time stamp should not be displayed
[ ] (if comments enabled) Comment list and comment reply form are displayed
[ ] (if comments disabled) Comment list and comment reply form are displayed
[ ] No "Comments Disabled" message should be displayed
[ ] Layout not adversely impacted by minimal page content

## Menus

[ ] Test with a large number of categories or pages in the menu, and test with
    multiple levels deep in the menus.
[ ] If custom menus are enabled, test the layout both with custom menus enabled and
    with the fallback navigation menus (no custom menu enabled)

## Widgets

[ ] All widgets display correctly
[ ] The default WordPress widgets should work correctly in all widgetized areas
[ ] If the Theme uses custom widgets, they should work correctly. (Custom widgets
    are programmatically added by the Theme to the list of available widgets in Appearance > Widgets)
[ ] Test all available widgets in all available widgetized areas in the Theme layout
[ ] Content that appears in widgetized areas by default (hard-coded into the sidebar,
    for example) should disappear when widgets are enabled from Appearance > Widgets