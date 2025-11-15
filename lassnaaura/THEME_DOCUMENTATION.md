# Frontend Theme Documentation
## White & Light Pink Color Scheme

## 🎨 Color Palette

### Primary Colors
```css
--primary-pink: #FFB6C1          /* Main pink color */
--primary-pink-light: #FFD4DB    /* Light pink for backgrounds */
--primary-pink-lighter: #FFE8ED  /* Very light pink for subtle backgrounds */
--primary-pink-dark: #FF9AAA     /* Darker pink for hover states */
--primary-pink-darker: #FF7D8F   /* Darkest pink for text and accents */
```

### Neutral Colors
```css
--white: #FFFFFF                 /* Pure white */
--off-white: #FAFAFA            /* Slightly off-white */
--light-gray: #F5F5F5           /* Light gray backgrounds */
--gray: #E0E0E0                 /* Borders and dividers */
--medium-gray: #BDBDBD          /* Secondary text */
--dark-gray: #757575            /* Muted text */
--text-primary: #333333         /* Primary text color */
--text-secondary: #666666       /* Secondary text color */
```

### Status Colors
```css
--success: #81C784               /* Success green */
--success-light: #C8E6C9         /* Light success background */
--warning: #FFB74D               /* Warning orange */
--warning-light: #FFE0B2         /* Light warning background */
--danger: #E57373                /* Danger red */
--danger-light: #FFCDD2          /* Light danger background */
--info: #64B5F6                  /* Info blue */
--info-light: #BBDEFB            /* Light info background */
```

## 📐 Design System

### Shadows
```css
--shadow-sm: 0 1px 3px rgba(255, 182, 193, 0.12), 0 1px 2px rgba(0, 0, 0, 0.08);
--shadow-md: 0 4px 6px rgba(255, 182, 193, 0.15), 0 2px 4px rgba(0, 0, 0, 0.1);
--shadow-lg: 0 10px 15px rgba(255, 182, 193, 0.2), 0 4px 6px rgba(0, 0, 0, 0.1);
--shadow-xl: 0 20px 25px rgba(255, 182, 193, 0.25), 0 10px 10px rgba(0, 0, 0, 0.1);
```

### Border Radius
```css
--radius-sm: 4px                 /* Small radius for inputs */
--radius-md: 8px                 /* Medium radius for buttons */
--radius-lg: 12px                /* Large radius for cards */
--radius-xl: 16px                /* Extra large for containers */
--radius-full: 9999px            /* Full circle/pill shape */
```

### Spacing
```css
--spacing-xs: 4px                /* Extra small spacing */
--spacing-sm: 8px                /* Small spacing */
--spacing-md: 16px               /* Medium spacing */
--spacing-lg: 24px               /* Large spacing */
--spacing-xl: 32px               /* Extra large spacing */
--spacing-2xl: 48px              /* 2X extra large spacing */
```

### Typography
```css
--font-sans: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
--font-mono: 'Fira Code', 'Courier New', monospace;
```

## 🧩 Component Styles

### Sidebar
- **Position:** Fixed left, full height
- **Width:** 260px
- **Background:** White to light pink gradient (180deg)
- **Border:** Right border with pink-light
- **Shadow:** Large shadow for depth
- **Logo:** Pink gradient icon with white background
- **Navigation:** Pink hover and active states with smooth transitions

### Header
- **Background:** Pure white
- **Border Radius:** Extra large (16px)
- **Shadow:** Medium shadow
- **Padding:** Generous spacing
- **Actions:** Buttons with pink theme, logout button in danger color

### Cards
- **Background:** Pure white
- **Border Radius:** Extra large (16px)
- **Shadow:** Medium shadow, increases on hover
- **Header:** Light pink gradient background
- **Title:** Pink-darker color, semi-bold
- **Hover Effect:** Slight lift animation (translateY -2px)

### Stats Cards
- **Background:** White to light pink gradient (135deg)
- **Border-left:** 4px solid pink accent
- **Icon:** Pink gradient background, white text
- **Value:** Large, bold, pink-darker color
- **Label:** Small, uppercase, secondary text
- **Hover:** Lifts more (translateY -4px) with increased shadow

### Buttons
- **Primary:** Pink gradient (135deg), white text
- **Secondary:** White background, pink border
- **Success:** Green gradient
- **Warning:** Orange gradient
- **Danger:** Red gradient
- **Hover:** Lifts up (translateY -2px), increased shadow
- **Border Radius:** Medium (8px)
- **Padding:** Comfortable spacing

### Forms
- **Label:** Medium weight, primary text color
- **Input:** 2px gray border, changes to pink on focus
- **Focus Shadow:** Light pink glow (3px)
- **Border Radius:** Medium (8px)
- **Select:** Custom pink arrow icon
- **Placeholder:** Medium gray color

### Tables
- **Header:** Pink-lighter to pink-light gradient
- **Header Text:** Pink-darker, uppercase, semi-bold
- **Row Hover:** Light pink background
- **Border:** Light gray between rows
- **Container:** White background, rounded corners

### Badges
- **Border Radius:** Full (pill shape)
- **Padding:** Compact but readable
- **Font:** Small, bold, uppercase
- **Primary:** Pink-light background, pink-darker text
- **Success:** Green-light background, dark green text
- **Warning:** Orange-light background, dark orange text
- **Danger:** Red-light background, dark red text

### Alerts
- **Border-left:** 4px colored accent
- **Background:** Light colored background
- **Icon:** Matches alert type
- **Success:** Green theme
- **Warning:** Orange theme
- **Danger:** Red theme
- **Info:** Blue theme

## 📱 Responsive Design

### Breakpoints
```css
@media (max-width: 768px) {
    /* Mobile devices */
    .sidebar { transform: translateX(-100%); }
    .main-content { margin-left: 0; }
    .col-md-* { flex: 0 0 100%; }
}
```

### Mobile Adaptations
- Sidebar slides in/out with toggle
- Main content takes full width
- Grid columns stack vertically
- Reduced padding on small screens
- Touch-friendly button sizes

## 🎭 Animations & Transitions

### Hover Effects
```css
transition: all 0.3s ease;
transform: translateY(-2px);  /* Lift effect */
```

### Active States
- Smooth color transitions
- Shadow depth changes
- Transform animations

### Auto-hide Alerts
- 5-second display time
- Fade-out opacity transition (0.5s)
- Automatic removal from DOM

## 🖼️ Layout Structure

### Main Layout
```
┌─────────────────────────────────────┐
│ Sidebar (260px)  │  Main Content   │
│                  │                  │
│ - Logo           │  - Header        │
│ - Navigation     │  - Flash Msgs    │
│                  │  - Page Content  │
│                  │                  │
└─────────────────────────────────────┘
```

### Grid System
- 12-column flexible grid
- Responsive breakpoints
- Automatic wrapping
- Gutters with margin

## 🎨 Page-Specific Styles

### Welcome Page
- Centered container
- Gradient background
- Large logo icon
- Feature grid
- Action buttons

### Login Page
- Centered form container
- Pink gradient header
- Form with validation
- Error alerts
- Back to home link

### Dashboard
- Stats cards grid
- Recent invoices table
- Low stock alerts
- Quick action buttons

## 📦 Files Created

1. **resources/css/theme.css** - Main theme file (10KB)
2. **resources/views/layouts/app.blade.php** - Updated layout
3. **resources/views/partials/sidebar.blade.php** - Pink-themed sidebar
4. **resources/views/welcome.blade.php** - Landing page
5. **resources/views/auth/login.blade.php** - Login page
6. **resources/views/dashboard.blade.php** - Dashboard view

## 🚀 Usage

### Applying the Theme
The theme is automatically applied to all views that extend `layouts.app`:

```php
@extends('layouts.app')

@section('title', 'Page Title')
@section('page-title', 'Dashboard')

@section('content')
    <!-- Your content here -->
@endsection
```

### Using Color Classes
```html
<!-- Primary pink button -->
<button class="btn btn-primary">Click Me</button>

<!-- Stats card -->
<div class="stats-card">
    <div class="stats-icon">
        <i class="fas fa-dollar-sign"></i>
    </div>
    <div class="stats-value">$45,850</div>
    <div class="stats-label">Revenue</div>
</div>

<!-- Badge -->
<span class="badge badge-success">Paid</span>

<!-- Alert -->
<div class="alert alert-success">
    <i class="fas fa-check-circle"></i>
    Success message!
</div>
```

### Grid Layout
```html
<div class="row">
    <div class="col-4">Column 1 (33%)</div>
    <div class="col-4">Column 2 (33%)</div>
    <div class="col-4">Column 3 (33%)</div>
</div>
```

### Card Component
```html
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Card Title</h3>
    </div>
    <div class="card-body">
        Card content goes here
    </div>
    <div class="card-footer">
        <button class="btn btn-primary">Action</button>
    </div>
</div>
```

## 🎯 Best Practices

1. **Consistency:** Use the defined color variables throughout
2. **Accessibility:** Maintain sufficient color contrast ratios
3. **Responsiveness:** Test on multiple screen sizes
4. **Performance:** Use transitions sparingly for smooth experience
5. **Semantic HTML:** Use proper HTML5 elements
6. **Icon Usage:** Font Awesome 6.4.0 for consistent icons
7. **Font Loading:** Google Fonts (Inter) for modern typography

## 🔧 Customization

To customize the theme, edit the CSS variables in `resources/css/theme.css`:

```css
:root {
    /* Change these values to customize */
    --primary-pink: #FFB6C1;
    --primary-pink-darker: #FF7D8F;
    /* ... other variables */
}
```

Then rebuild with:
```bash
npm run build
```

## 📊 Browser Support

- Chrome 90+
- Firefox 88+
- Safari 14+
- Edge 90+
- Mobile browsers (iOS Safari, Chrome Mobile)

## 🌟 Features

✅ Modern white & light pink color scheme
✅ Responsive sidebar navigation
✅ Beautiful gradient effects
✅ Smooth animations and transitions
✅ Consistent component styling
✅ Mobile-first approach
✅ Accessible color contrasts
✅ Clean and professional design
✅ Easy to customize
✅ Production-ready build

## 📝 Notes

- Theme is built with CSS custom properties for easy customization
- All components use the same design tokens
- Shadows use pink tints for cohesive look
- Font Awesome icons integrated throughout
- Inter font for modern, clean typography
- Optimized for business management interface
