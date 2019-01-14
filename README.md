# wkhtmltopdf-stroke-dashoffset-for-svg

PHP helper class that calculates values for stroke-dasharray parameter of SVG images.

There is a known bug in WKHTMLTOPDF which prevents donut charts generated using SVG images to correctly render the stroke-dashoffset parameter resulting in incorrect data visualisation. 

The bug is reported here
https://github.com/wkhtmltopdf/wkhtmltopdf/issues/3031

The solution is to ignore the stroke-dashoffset parameter and have a complex calculation of the four points used in the stroke-dasharray parameter. This is where this Helper class comes into place.

## Usage

```php
$svgChart = new SvgChart($score = 33, $maxScore = 100);
$dashArray = $svgChart->dashArray();
```

## Example

```php
$svgChart = new SvgChart(33, 100);
```

```html
<svg width="212px" height="212px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 212 212">
    <!-- full circle, at 90 radius, is 566 units in circumference -->
    <!-- now try a second set (to right) with dash offset 0, to work around
         problem in wkHTMLtoPDF (ignoring dash offset) -->
    <g>
        <!-- background full circle 566 on, 0 off -->
        <circle r="90" cy="106" cx="106" stroke-width="20"
                stroke="#d9d9d9" fill="none"
                stroke-dasharray="424 283"></circle>
        <!-- filled portion of arc. to get around dashoffset being ignored,
             dash cycle is CW, length is .25 arc on, .5 off, .25 on  -->
        <circle r="90" cy="106" cx="106" stroke-width="20"
                stroke="#26af61" fill="none"
                stroke-dasharray="<?= $svgChart->dashArray() ?>"></circle>
        <text transform="translate(80, 125)" style="font-size:36pt">33</text>
    </g>
</svg>
```