# Contribution Guide
> [Korean](/CONTRIBUTING_kor.md)

Looking to contribute something to XEIcon? Here's how you can help.



## Requesting new icons

New icons mostly start as requests by the [XEIcon community on GitHub](../../issues). Want to request a new icon? Here are some things to keep in mind:

1. Please [search](../../search?type=Issues) to see if your icon request already exists. If a request is found, please +1 that one.
2. Please make requests for single icons, unless you are requesting a couple of strictly related icons (e.g., thumbs-up/thumbs-down).
3. Please and thank you if you include the following:
  - Title your [new issue](../../issues/new?title=Icon%20Request:%20icon-) `Icon request: icon-name` (e.g., `Icon request: xpressengine`).
  - Include a few use cases for your requested icon. How do you plan on using it?
  - Attach a single color image or two that represent the idea you're going for.
  - Request concrete objects.



## Reporting issues

We only accept issues that are icon requests, bug reports, or feature requests. Bugs must be isolated and reproducible problems that we can fix within the XEIcon core. Please read the following guidelines to ensure you are the paragon of bug reporting.

1. **Search for existing issues.** You'd help us out a lot by first checking if someone else has reported the same issue. Moreover, you can reply on existing issue.
2. **Please Make an issue for single problem or suggestion.** Do not provide one of two or more subject matter in one issue.
3. **Create an isolated and reproducible test case.** Be sure the problem exists in XEIcon's code with a [reduced test case](http://css-tricks.com/reduced-test-cases/) that should be included in each bug report.
4. **Include a live example.** Make use of [jsFiddle](http://jsfiddle.net/), [jsBin](http://jsbin.com/), or [Codepen](http://codepen.io/) to share your isolated test cases.
5. **Share as much information as possible.** Include operating system and version, browser and version, version of XEIcon, etc. where appropriate. Also include steps to reproduce the bug.



## Key branches

- `master` is the latest, deployed version (not to be used for pull requests)
- `*-wip` branches are the official work in progress branches for the next releases. All pull requests should be submitted against the appropriate branch
- `gh-pages` is the hosted docs (not to be used for pull requests)
- `orginallibary` is the grunt-deploy for library page (not to be used for pull requests)



## Notes on the repo
- `orginallibary branch, src/` - All edits to documentation, LESS, SCSS, and CSS should be made to files and templates in this directory
- `orginallibary branch,  selection.json` -  all LESS, SCSS, and CSS icon definitions are  generated from this single file



## Coding standards: HTML
- One tabs for indentation, never spaces
- Double quotes only, never single quotes
- Always use proper indentation
- Use tags and elements appropriate for an HTML5 doctype (e.g., self-closing tags)



## Coding standards: CSS
- Write a single line to make the CSS code more readable
- The CSS code is to minimize the space.
- End all lines with a semi-colon for SASS, LESS.
- Attribute selectors, like `input[type="text"]` should always wrap the attribute's value in double quotes, for - consistency and safety (see this blog post on unquoted attribute values that can lead to XSS attacks)



## Pull requests

- At the moment we are not accepting pull requests containing icons
- Submit all pull requests against the appropriate `*-wip` branch for easier merging
- Any changes to the styles must be made to the .less and .scss files in the `src` directory
- If modifying the .less and .scss files, always recompile and commit the compiled files
- Try not to pollute your pull request with unintended changes--keep them simple and small
- Try to share which browsers your code has been tested in before submitting a pull request



## License

By contributing your code, you agree to license your contribution under the terms of the MIT License:
- http://opensource.org/licenses/mit-license.html


