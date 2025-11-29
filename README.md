# ETS Website

A modern, responsive website built with HTML, CSS, and JavaScript.

## Features

- **Responsive Design**: Works seamlessly on desktop, tablet, and mobile devices
- **Modern UI/UX**: Clean, professional design with smooth animations
- **Smooth Scrolling**: Navigation with smooth scroll behavior
- **Interactive Elements**: Hover effects, animations, and transitions
- **Contact Form**: Functional contact form (ready for backend integration)
- **Mobile Menu**: Hamburger menu for mobile navigation

## File Structure

```
ets/
├── index.html      # Main HTML file
├── styles.css      # All styling and responsive design
├── script.js       # JavaScript for interactivity
└── README.md       # This file
```

## Getting Started

1. Open `index.html` in your web browser
2. Or serve it using a local server:
   - Using Python: `python -m http.server 8000`
   - Using Node.js: `npx serve`
   - Using PHP: `php -S localhost:8000`

## Sections

- **Home/Hero**: Eye-catching landing section with call-to-action buttons
- **About**: Information about the company/individual
- **Services**: Showcase of services offered
- **Portfolio**: Display of recent work/projects
- **Contact**: Contact form and information

## Customization

### Colors
Edit the CSS variables in `styles.css`:
```css
:root {
    --primary-color: #6366f1;
    --secondary-color: #8b5cf6;
    /* ... */
}
```

### Content
Edit the HTML content in `index.html` to match your needs.

### Contact Form
The contact form currently shows an alert on submission. To make it functional:
1. Add a backend endpoint
2. Update the form submission handler in `script.js`

## Browser Support

- Chrome (latest)
- Firefox (latest)
- Safari (latest)
- Edge (latest)

## License

This project is open source and available for personal and commercial use.

