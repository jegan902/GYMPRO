<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GYMPRO | CLUB THE ULTIMATE TRAINING</title>
    
    <!-- Fonts & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700;900&family=Plus+Jakarta+Sans:wght@700;800;900&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary-red: #FF5E00; /* Athletic Orange */
            --primary-red-glow: rgba(255, 94, 0, 0.15);
            --dark-luxury-bg: #F4F6F9; /* Clean light grey-blue background */
            --dark-luxury-card: #FFFFFF; /* Pure white surface */
            --dark-border: #E2E8F0; /* Soft borders */
            --text-light: #1E293B; /* Deep Slate text */
            --text-muted: #64748B; /* Slate grey muted text */
            --red-gradient: linear-gradient(135deg, #FF7A00 0%, #FF5E00 100%);
            --grey-gradient: linear-gradient(180deg, #FFFFFF 0%, #F1F5F9 100%);
        }

        body {
            font-family: 'Outfit', sans-serif;
            background-color: var(--dark-luxury-bg);
            color: var(--text-light);
            margin: 0;
            overflow-x: hidden;
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 200 200' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noiseFilter'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.8' numOctaves='3' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noiseFilter)' opacity='0.015'/%3E%3C/svg%3E");
        }

        /* Scrollbar styling */
        ::-webkit-scrollbar {
            width: 8px;
        }
        ::-webkit-scrollbar-track {
            background: var(--dark-luxury-bg);
        }
        ::-webkit-scrollbar-thumb {
            background: #CBD5E1;
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: var(--primary-red);
        }

        /* Glow effects */
        .glow-orb {
            position: absolute;
            border-radius: 50%;
            filter: blur(160px);
            z-index: 0;
            pointer-events: none;
            opacity: 0.12;
        }
        .orb-red {
            background: var(--primary-red);
            width: 600px;
            height: 600px;
            top: 5%;
            right: -10%;
        }
        .orb-blue {
            background: #2E90FF;
            width: 500px;
            height: 500px;
            bottom: 15%;
            left: -10%;
        }

        /* Navbar */
        .navbar {
            backdrop-filter: blur(20px);
            background: rgba(244, 246, 249, 0.8);
            border-bottom: 1px solid var(--dark-border);
            padding: 20px 0;
            transition: all 0.3s;
            z-index: 9999;
        }
        .navbar.scrolled {
            padding: 14px 0;
            background: rgba(255, 255, 255, 0.96);
            box-shadow: 0 10px 30px rgba(15, 23, 42, 0.04);
        }
        .navbar-brand {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-weight: 900;
            font-size: 1.8rem;
            letter-spacing: -1px;
            color: #1E293B !important;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .navbar-brand span {
            color: var(--primary-red);
        }
        .nav-link {
            color: #1E293B !important;
            font-weight: 700;
            font-size: 0.9rem;
            padding: 8px 16px !important;
            transition: all 0.3s;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }
        .nav-link:hover {
            color: var(--primary-red) !important;
        }
        .btn-login {
            background: transparent;
            border: 1px solid #1E293B;
            color: #1E293B !important;
            font-weight: 700;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            padding: 12px 28px;
            border-radius: 4px;
            transition: all 0.3s;
            text-decoration: none;
        }
        .btn-login:hover {
            background: #1E293B;
            color: white !important;
            box-shadow: 0 4px 12px rgba(30, 41, 59, 0.15);
            transform: translateY(-2px);
        }

        /* Hero Section - Asymmetrical Editorial */
        .hero-section {
            padding-top: 190px;
            padding-bottom: 140px;
            position: relative;
            z-index: 1;
            overflow: hidden;
        }
        .hero-layout {
            display: grid;
            grid-template-columns: 1.2fr 0.8fr;
            gap: 40px;
            align-items: center;
        }
        @media(max-width: 991px) {
            .hero-layout {
                grid-template-columns: 1fr;
            }
        }
        .hero-badge {
            background: rgba(255, 94, 0, 0.08);
            border: 1px solid rgba(255, 94, 0, 0.2);
            color: var(--primary-red);
            font-weight: 800;
            font-size: 0.75rem;
            letter-spacing: 3px;
            text-transform: uppercase;
            padding: 8px 16px;
            border-radius: 4px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 30px;
        }
        .hero-title {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 5.5rem;
            font-weight: 900;
            line-height: 0.95;
            margin-bottom: 30px;
            letter-spacing: -3px;
            text-transform: uppercase;
            color: #1E293B;
        }
        .hero-title span {
            background: var(--red-gradient);
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .hero-lead {
            font-size: 1.15rem;
            color: var(--text-muted);
            margin-bottom: 45px;
            line-height: 1.7;
            max-width: 620px;
        }
        
        /* Premium Campaign Buttons */
        .btn-red-glow {
            background: var(--red-gradient);
            color: white;
            font-weight: 800;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            padding: 18px 38px;
            border-radius: 4px;
            border: none;
            box-shadow: 0 8px 24px rgba(255, 94, 0, 0.25);
            transition: all 0.3s cubic-bezier(0.165, 0.84, 0.44, 1);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 10px;
        }
        .btn-red-glow:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 32px rgba(255, 94, 0, 0.45);
            color: white;
        }
        .btn-outline-minimal {
            background: transparent;
            border: 1px solid #1E293B;
            color: #1E293B;
            font-weight: 800;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            padding: 18px 38px;
            border-radius: 4px;
            transition: all 0.3s;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
        }
        .btn-outline-minimal:hover {
            background: rgba(30, 41, 59, 0.04);
            border-color: var(--primary-red);
            color: var(--primary-red);
            transform: translateY(-2px);
        }

        /* Oversized BG Text */
        .giant-outline-text {
            position: absolute;
            right: 0;
            bottom: 0;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 15rem;
            font-weight: 900;
            line-height: 1;
            color: transparent;
            -webkit-text-stroke: 1px rgba(255, 94, 0, 0.05);
            pointer-events: none;
            z-index: -1;
            text-transform: uppercase;
        }

        /* Hero Image Container */
        .hero-poster-container {
            position: relative;
            height: 580px;
            border-radius: 8px;
            overflow: hidden;
            border: 1px solid var(--dark-border);
            box-shadow: 0 20px 40px rgba(15, 23, 42, 0.08);
        }
        .hero-poster-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            filter: grayscale(20%) contrast(105%) brightness(95%);
            transition: all 0.8s cubic-bezier(0.165, 0.84, 0.44, 1);
        }
        .hero-poster-container:hover .hero-poster-img {
            transform: scale(1.05);
            filter: grayscale(0%) contrast(110%) brightness(100%);
        }
        .hero-poster-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            padding: 40px;
            background: linear-gradient(to top, rgba(15, 23, 42, 0.85) 0%, rgba(15, 23, 42, 0) 100%);
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
        }
        
        /* Brush Divider Effect */
        .brush-divider {
            height: 100px;
            background: linear-gradient(to bottom, var(--dark-luxury-bg) 0%, transparent 100%);
            pointer-events: none;
        }

        /* Sections General */
        .section-header {
            margin-bottom: 70px;
            position: relative;
            z-index: 1;
        }
        .section-header.text-center {
            text-align: center;
        }
        .section-tag {
            color: var(--primary-red);
            font-weight: 900;
            font-size: 0.8rem;
            letter-spacing: 4px;
            text-transform: uppercase;
            margin-bottom: 16px;
            display: block;
        }
        .section-title-text {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 3.5rem;
            font-weight: 900;
            letter-spacing: -2px;
            text-transform: uppercase;
            line-height: 1.1;
            color: #1E293B;
        }

        /* Glassmorphism Premium Cards */
        .premium-card {
            background: var(--dark-luxury-card);
            border: 1px solid var(--dark-border);
            border-radius: 8px;
            padding: 40px;
            transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
            position: relative;
            overflow: hidden;
            z-index: 1;
            box-shadow: 0 10px 30px rgba(15, 23, 42, 0.02);
        }
        .premium-card::before {
            content: '';
            position: absolute;
            top: 0; left: 0; width: 100%; height: 100%;
            background: linear-gradient(135deg, rgba(255, 94, 0, 0.05) 0%, rgba(255, 94, 0, 0) 100%);
            opacity: 0;
            transition: opacity 0.4s;
            z-index: -1;
        }
        .premium-card:hover {
            transform: translateY(-8px);
            border-color: var(--primary-red);
            box-shadow: 0 20px 40px rgba(255, 94, 0, 0.08);
        }
        .premium-card:hover::before {
            opacity: 1;
        }

        .feature-num {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 3rem;
            font-weight: 900;
            color: transparent;
            -webkit-text-stroke: 1.5px var(--primary-red);
            line-height: 1;
            margin-bottom: 24px;
            opacity: 0.7;
        }

        /* Branch Tab Buttons System */
        .branch-tabs {
            display: flex;
            justify-content: center;
            gap: 16px;
            margin-bottom: 50px;
            flex-wrap: wrap;
        }
        .branch-tab-btn {
            background: #FFFFFF;
            border: 1px solid var(--dark-border);
            color: #64748B;
            padding: 14px 32px;
            border-radius: 4px;
            font-weight: 700;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            cursor: pointer;
            transition: all 0.3s;
            box-shadow: 0 2px 4px rgba(15, 23, 42, 0.01);
        }
        .branch-tab-btn.active, .branch-tab-btn:hover {
            background: var(--primary-red);
            border-color: var(--primary-red);
            color: white;
            box-shadow: 0 8px 20px rgba(255, 94, 0, 0.2);
        }

        .branch-portal-grid {
            display: grid;
            grid-template-columns: 1fr 1.6fr;
            gap: 40px;
        }
        @media(max-width: 991px) {
            .branch-portal-grid {
                grid-template-columns: 1fr;
            }
        }

        .branch-meta-item {
            display: flex;
            align-items: flex-start;
            gap: 16px;
            margin-bottom: 30px;
        }
        .branch-meta-icon {
            width: 46px;
            height: 46px;
            background: #FFFFFF;
            border-radius: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary-red);
            font-size: 1.25rem;
            border: 1px solid var(--dark-border);
            flex-shrink: 0;
            box-shadow: 0 2px 4px rgba(15, 23, 42, 0.01);
        }

        /* Team Cards (CMS Roles) */
        .staff-section-title {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 1.15rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 2px;
            color: #1E293B;
            border-left: 3px solid var(--primary-red);
            padding-left: 14px;
            margin-bottom: 24px;
        }

        .manager-card {
            background: linear-gradient(135deg, rgba(255, 94, 0, 0.04) 0%, rgba(255, 255, 255, 0.9) 100%);
            border: 1px solid var(--dark-border);
            border-radius: 8px;
            padding: 30px;
            display: flex;
            align-items: center;
            gap: 24px;
            box-shadow: 0 4px 12px rgba(15, 23, 42, 0.01);
        }
        .staff-avatar {
            width: 80px;
            height: 80px;
            border-radius: 4px;
            object-fit: cover;
            border: 2px solid #E2E8F0;
            background-color: #F8FAFC;
            filter: grayscale(10%);
        }
        .manager-card .staff-avatar {
            border-color: var(--primary-red);
            box-shadow: 0 0 15px var(--primary-red-glow);
        }
        .role-badge {
            font-size: 0.7rem;
            font-weight: 900;
            padding: 4px 12px;
            border-radius: 2px;
            text-transform: uppercase;
            letter-spacing: 1px;
            display: inline-block;
        }
        .badge-mgr {
            background: var(--primary-red);
            color: white;
        }
        .badge-pt {
            background: #F1F5F9;
            color: #64748B;
            border: 1px solid var(--dark-border);
        }

        .staff-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
            gap: 20px;
        }
        .staff-card {
            background: #FFFFFF;
            border: 1px solid var(--dark-border);
            border-radius: 6px;
            padding: 24px;
            text-align: center;
            transition: all 0.3s;
            box-shadow: 0 2px 4px rgba(15, 23, 42, 0.01);
        }
        .staff-card:hover {
            background: #FFFFFF;
            border-color: var(--primary-red);
            transform: translateY(-4px);
            box-shadow: 0 8px 16px rgba(255, 94, 0, 0.05);
        }
        .staff-card .staff-avatar {
            width: 70px;
            height: 70px;
            margin-bottom: 16px;
        }

        /* Membership Packages Section - High End */
        .pkg-card {
            background: var(--dark-luxury-card);
            border: 1px solid var(--dark-border);
            border-radius: 8px;
            padding: 50px 35px;
            text-align: center;
            position: relative;
            transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            box-shadow: 0 10px 30px rgba(15, 23, 42, 0.02);
        }
        .pkg-card.premium {
            border: 1.5px solid var(--primary-red);
            background: linear-gradient(180deg, #FFFFFF 0%, rgba(255, 94, 0, 0.01) 100%);
            transform: scale(1.03);
            box-shadow: 0 20px 40px rgba(255, 94, 0, 0.05);
        }
        @media(max-width: 991px) {
            .pkg-card.premium {
                transform: scale(1);
            }
        }
        .pkg-card.premium::after {
            content: 'PHỔ BIẾN';
            position: absolute;
            top: 20px;
            right: 20px;
            background: var(--primary-red);
            color: white;
            font-size: 0.65rem;
            font-weight: 950;
            padding: 4px 12px;
            border-radius: 2px;
            letter-spacing: 1.5px;
        }
        .pkg-name {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 1.5rem;
            font-weight: 900;
            text-transform: uppercase;
            margin-bottom: 10px;
            color: #1E293B;
            letter-spacing: -0.5px;
        }
        .pkg-price-box {
            margin: 30px 0;
        }
        .pkg-price {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 3.5rem;
            font-weight: 950;
            color: #1E293B;
            line-height: 1;
            letter-spacing: -2px;
        }
        .pkg-price span {
            font-size: 1.25rem;
            color: var(--text-muted);
            font-weight: 600;
            margin-left: 2px;
        }
        .pkg-features {
            list-style: none;
            padding: 0;
            margin: 35px 0;
            text-align: left;
        }
        .pkg-features li {
            margin-bottom: 16px;
            font-size: 0.95rem;
            color: #334155;
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .pkg-features li i {
            color: var(--primary-red);
            font-size: 1.1rem;
        }
        .btn-pkg {
            width: 100%;
            padding: 16px;
            border-radius: 4px;
            font-weight: 800;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            border: 1px solid #1E293B;
            background: #FFFFFF;
            color: #1E293B;
            transition: all 0.3s;
            text-decoration: none;
            display: inline-block;
        }
        .pkg-card.premium .btn-pkg {
            background: var(--red-gradient);
            border: none;
            color: white;
            box-shadow: 0 6px 16px rgba(255, 94, 0, 0.2);
        }
        .pkg-card.premium .btn-pkg:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(255, 94, 0, 0.3);
        }
        .pkg-card:not(.premium) .btn-pkg:hover {
            background: #1E293B;
            color: white;
            border-color: #1E293B;
            transform: translateY(-2px);
        }

        /* Banner CTA - Campaign style */
        .cta-banner {
            background: linear-gradient(135deg, rgba(255, 94, 0, 0.05) 0%, rgba(255, 255, 255, 0.95) 100%);
            border: 1px solid rgba(255, 94, 0, 0.15);
            border-radius: 8px;
            padding: 80px 40px;
            text-align: center;
            margin-top: 120px;
            position: relative;
            overflow: hidden;
            box-shadow: 0 20px 40px rgba(15, 23, 42, 0.03);
        }
        .cta-banner h2 {
            color: #1E293B !important;
        }
        .cta-banner::before {
            content: '';
            position: absolute;
            top: 0; left: 0; width: 100%; height: 100%;
            background-image: url("https://images.unsplash.com/photo-1541534741688-6078c6bfb5c5?q=80&w=1200");
            background-size: cover;
            background-position: center;
            opacity: 0.04;
            filter: grayscale(100%);
            z-index: 0;
        }

        /* Interactive BMR / BMI WHOOP-style Preview Widget */
        .analytics-preview-widget {
            background: var(--dark-luxury-card);
            border: 1px solid var(--dark-border);
            border-radius: 8px;
            padding: 40px;
            position: relative;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(15, 23, 42, 0.02);
        }
        .circular-progress-box {
            position: relative;
            width: 180px;
            height: 180px;
            margin: 0 auto;
        }
        .circular-progress-box svg {
            width: 100%;
            height: 100%;
            transform: rotate(-90deg);
        }
        .circular-bg {
            fill: none;
            stroke: #E2E8F0;
            stroke-width: 8;
        }
        .circular-bar {
            fill: none;
            stroke: var(--primary-red);
            stroke-width: 8;
            stroke-linecap: round;
            stroke-dasharray: 440;
            stroke-dashoffset: 110; /* 75% */
            transition: stroke-dashoffset 1s ease-in-out;
        }
        .circular-value {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            text-align: center;
        }
        .circular-value .h3 {
            color: #1E293B !important;
        }
        .calc-input {
            background: #F8FAFC;
            border: 1px solid var(--dark-border);
            border-radius: 4px;
            color: #1E293B;
            padding: 12px 16px;
            width: 100%;
            outline: none;
            transition: all 0.3s;
            font-size: 0.9rem;
        }
        .calc-input:focus {
            border-color: var(--primary-red);
            box-shadow: 0 0 10px var(--primary-red-glow);
        }
        .calc-label {
            font-size: 0.75rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: var(--text-muted);
            margin-bottom: 8px;
            display: block;
        }

        /* Footer */
        footer {
            background: #0F172A;
            border-top: 1px solid rgba(255,255,255,0.05);
            padding: 80px 0 40px;
            color: #94A3B8;
            font-size: 0.9rem;
        }
        .footer-logo {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-weight: 900;
            font-size: 1.6rem;
            color: white;
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .footer-logo span {
            color: var(--primary-red);
        }
        .footer-links {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        .footer-links li {
            margin-bottom: 14px;
        }
        .footer-links a {
            color: var(--text-muted);
            text-decoration: none;
            transition: color 0.3s;
            font-weight: 600;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .footer-links a:hover {
            color: white;
        }

        /* Introduction Section */
        .intro-section {
            padding: 100px 0;
            position: relative;
            z-index: 1;
            overflow: hidden;
        }
        .intro-grid {
            display: grid;
            grid-template-columns: 1fr 1.1fr;
            gap: 60px;
            align-items: center;
        }
        @media(max-width: 991px) {
            .intro-grid {
                grid-template-columns: 1fr;
                gap: 40px;
            }
        }
        .intro-image-wrapper {
            position: relative;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 20px 40px rgba(15, 23, 42, 0.08);
            border: 1px solid var(--dark-border);
        }
        .intro-image {
            width: 100%;
            height: 520px;
            object-fit: cover;
            filter: grayscale(10%) contrast(105%) brightness(95%);
            transition: all 0.5s;
        }
        .intro-image-wrapper:hover .intro-image {
            transform: scale(1.03);
            filter: grayscale(0%) contrast(110%);
        }
        .intro-tagline {
            font-size: 1.15rem;
            font-weight: 700;
            color: var(--primary-red);
            margin-bottom: 15px;
            display: block;
            text-transform: uppercase;
            letter-spacing: 2px;
        }
        .intro-title {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 2.8rem;
            font-weight: 900;
            line-height: 1.15;
            color: #1E293B;
            margin-bottom: 25px;
            text-transform: uppercase;
            letter-spacing: -1px;
        }
        .intro-desc {
            font-size: 1.05rem;
            color: var(--text-muted);
            line-height: 1.7;
            margin-bottom: 35px;
        }
        .intro-stats-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin-bottom: 35px;
        }
        .intro-stat-card {
            background: #FFFFFF;
            border: 1px solid var(--dark-border);
            border-radius: 6px;
            padding: 20px 15px;
            text-align: center;
            box-shadow: 0 4px 12px rgba(15, 23, 42, 0.01);
            transition: all 0.3s;
        }
        .intro-stat-card:hover {
            border-color: var(--primary-red);
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(255, 94, 0, 0.05);
        }
        .intro-stat-number {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 2rem;
            font-weight: 900;
            color: var(--primary-red);
            line-height: 1;
            margin-bottom: 6px;
        }
        .intro-stat-label {
            font-size: 0.75rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #64748B;
        }
        .intro-features-list {
            list-style: none;
            padding: 0;
            margin: 0 0 35px 0;
        }
        .intro-features-list li {
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 1rem;
            color: #334155;
            margin-bottom: 12px;
            font-weight: 600;
        }
        .intro-features-list li i {
            color: var(--primary-red);
            font-size: 1.25rem;
        }
    </style>
</head>

<body>
    <!-- Glow Orbs background -->
    <div class="glow-orb orb-red"></div>
    <div class="glow-orb orb-blue"></div>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg fixed-top" id="mainNavbar">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
                <i class="bi bi-lightning-charge-fill" style="color: var(--primary-red);"></i> GYM<span>PRO</span>
            </a>
            <button class="navbar-toggler border-0 text-white" type="button" data-bs-toggle="collapse" data-bs-target="#navContent">
                <i class="bi bi-list fs-2"></i>
            </button>
            <div class="collapse navbar-collapse" id="navContent">
                <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link" href="{{ route('about') }}">{{ __('Giới thiệu') }}</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('news') }}">{{ __('Tin tức') }}</a></li>
                    <li class="nav-item"><a class="nav-link" href="#pricing">{{ __('Gói tập') }}</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('contact') }}">{{ __('Liên hệ') }}</a></li>
                </ul>
                <div class="d-flex align-items-center gap-3">
                    <!-- Language Switcher (vi/en) -->
                    <div class="dropdown me-1">
                        <button class="btn btn-outline-secondary btn-sm dropdown-toggle text-uppercase fw-bold" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="font-size: 0.75rem; border-color: var(--dark-border); color: var(--text-light); padding: 8px 14px;">
                            <i class="bi bi-globe me-1" style="color: var(--primary-red);"></i>{{ App::getLocale() }}
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow-sm border-light">
                            <li><a class="dropdown-item fw-semibold" href="{{ route('lang.switch', 'vi') }}">Tiếng Việt (VI)</a></li>
                            <li><a class="dropdown-item fw-semibold" href="{{ route('lang.switch', 'en') }}">English (EN)</a></li>
                        </ul>
                    </div>

                    <!-- User Account Icon Button -->
                    @if(session('api_token'))
                        <a href="{{ route('admin.dashboard') }}" class="btn-login d-flex align-items-center gap-2" title="{{ __('Vào Dashboard') }}">
                            <i class="bi bi-person-circle fs-5" style="color: var(--primary-red);"></i>
                            <span class="d-none d-md-inline">{{ __('Vào Dashboard') }}</span>
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="btn-login d-flex align-items-center gap-2" title="{{ __('Đăng nhập') }}">
                            <i class="bi bi-person-fill fs-5"></i>
                            <span class="d-none d-md-inline">{{ __('Đăng nhập') }}</span>
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <header class="hero-section">
        <div class="container">
            <div class="hero-layout">
                <div>
                    <div class="hero-badge">
                        <i class="bi bi-lightning-fill"></i> Club The Ultimate Training
                    </div>
                    <h1 class="hero-title">
                        <?php echo __('Kiến Tạo'); ?><br><?php echo __('Vóc Dáng'); ?> <span><?php echo __('Vượt Trội'); ?></span>
                    </h1>
                    <p class="hero-lead">
                        <?php echo __('Hệ thống GymPro cung cấp không gian tập luyện hiện đại, máy móc đạt chuẩn Olympic cùng đội ngũ PT chuyên nghiệp đồng hành giúp bạn đạt hiệu quả tối ưu nhất.'); ?>
                    </p>
                    <div class="d-flex flex-wrap gap-3">
                        @if(session('api_token'))
                            <a href="{{ route('admin.dashboard') }}" class="btn-red-glow">
                                <?php echo __('TRUY CẬP DASHBOARD'); ?> <i class="bi bi-chevron-right"></i>
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="btn-red-glow">
                                <?php echo __('BẮT ĐẦU NGAY'); ?> <i class="bi bi-lightning-fill"></i>
                            </a>
                        @endif
                        <a href="#pricing" class="btn-outline-minimal"><?php echo __('Khám phá gói tập'); ?></a>
                    </div>
                </div>
                <div>
                    <div class="hero-poster-container">
                        <img src="https://images.unsplash.com/photo-1517838277536-f5f99be501cd?q=80&w=1000" 
                             alt="Workout Fitness" class="hero-poster-img">
                        <div class="hero-poster-overlay">
                            <span class="role-badge badge-mgr mb-2 w-auto align-self-start" style="font-size: 0.6rem;">HIGH INTENSITY</span>
                            <h4 class="fw-bold text-white mb-1 uppercase">LIMITLESS POTENTIAL</h4>
                            <p class="text-muted small mb-0"><?php echo __('Hệ thống phòng tập cao cấp chuẩn Olympic và đội ngũ huấn luyện viên (PT) chuyên nghiệp hỗ trợ bạn.'); ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="giant-outline-text">LIMITLESS</div>
    </header>

    <div class="brush-divider"></div>

    <!-- About / Introduction Section -->
    <section id="about" class="intro-section">
        <div class="container">
            <div class="intro-grid">
                <!-- Left: Interactive High-End Visual -->
                <div class="intro-image-wrapper">
                    <img src="https://images.unsplash.com/photo-1517838277536-f5f99be501cd?q=80&w=1000" 
                         alt="GymPro Studio" class="intro-image">
                </div>
                
                <!-- Right: Editorial Content -->
                <div>
                    <span class="intro-tagline"><?php echo __('Về chúng tôi'); ?></span>
                    <h2 class="intro-title"><?php echo __('Chào mừng bạn đến với GymPro'); ?></h2>
                    <p class="intro-desc">
                        <?php echo __('GymPro không chỉ đơn thuần là một trung tâm thể hình. Chúng tôi là một hệ sinh thái tập luyện hiện đại và toàn diện. Với định hướng mang lại trải nghiệm cao cấp nhưng vô cùng dễ tiếp cận, GymPro kết hợp hài hòa giữa không gian tập luyện hiện đại, trang thiết bị đạt chuẩn Olympic và đội ngũ huấn luyện viên (PT) chuyên nghiệp tận tâm.'); ?>
                    </p>
                    
                    <!-- Approachable Trust Metrics -->
                    <div class="intro-stats-grid">
                        <div class="intro-stat-card">
                            <div class="intro-stat-number">15+</div>
                            <div class="intro-stat-label"><?php echo __('Chi nhánh'); ?></div>
                        </div>
                        <div class="intro-stat-card">
                            <div class="intro-stat-number">50K+</div>
                            <div class="intro-stat-label"><?php echo __('Hội viên'); ?></div>
                        </div>
                        <div class="intro-stat-card">
                            <div class="intro-stat-number">98%</div>
                            <div class="intro-stat-label"><?php echo __('Hài lòng'); ?></div>
                        </div>
                    </div>

                    <!-- Highlight Features -->
                    <ul class="intro-features-list">
                        <li><i class="bi bi-patch-check-fill"></i> <?php echo __('Đội ngũ Huấn luyện viên chuyên môn cao, hỗ trợ tận tâm.'); ?></li>
                        <li><i class="bi bi-patch-check-fill"></i> <?php echo __('Chương trình tập luyện khoa học thiết kế riêng cho từng hội viên.'); ?></li>
                        <li><i class="bi bi-patch-check-fill"></i> <?php echo __('Trang thiết bị nhập khẩu 100% đạt chuẩn Olympic.'); ?></li>
                    </ul>

                    <a href="{{ route('about') }}" class="btn-red-glow"><?php echo __('Xem Chi Tiết Giới Thiệu'); ?> <i class="bi bi-arrow-right-short ms-1"></i></a>
                    <a href="#pricing" class="btn-outline-minimal ms-2"><?php echo __('Khám phá gói tập'); ?></a>
                </div>
            </div>
        </div>
    </section>

    <!-- Member Testimonials Section -->
    <section id="testimonials" class="py-5 my-5">
        <div class="container">
            <div class="section-header text-center">
                <span class="section-tag"><?php echo __('Hành Trình Thay Đổi'); ?></span>
                <h2 class="section-title-text text-dark"><?php echo __('Đánh Giá Từ Hội Viên'); ?></h2>
                <p class="text-muted mx-auto mt-3" style="max-width: 600px;">
                    <?php echo __('Nhận xét chân thực từ các học viên, hội viên đã trực tiếp trải nghiệm môi trường tập luyện cao cấp tại hệ thống GymPro.'); ?>
                </p>
            </div>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="testimonial-card h-100 d-flex flex-column justify-content-between">
                        <div>
                            <div class="testimonial-stars">
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                            </div>
                            <p class="testimonial-quote">
                                "<?php echo __('Không gian tập vô cùng thoáng mát, máy móc nhập khẩu xịn xò. Đội ngũ PT ở đây rất thân thiện và nhiệt tình, hướng dẫn mình từng buổi tập động tác chuẩn xác.'); ?>"
                            </p>
                        </div>
                        <div class="testimonial-author">
                            <img src="https://images.unsplash.com/photo-1544005313-94ddf0286df2?q=80&w=150" alt="Member Avatar" class="testimonial-avatar">
                            <div>
                                <div class="testimonial-name">Minh Thư</div>
                                <div class="testimonial-pkg"><?php echo __('Gói VIP 6 Tháng'); ?></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="testimonial-card h-100 d-flex flex-column justify-content-between">
                        <div>
                            <div class="testimonial-stars">
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                            </div>
                            <p class="testimonial-quote">
                                "<?php echo __('Mình đã giảm được 8kg chỉ sau 3 tháng tập luyện theo giáo án của PT tại GymPro. Dịch vụ chăm sóc khách hàng tốt, phòng tắm và locker cực kỳ sạch sẽ.'); ?>"
                            </p>
                        </div>
                        <div class="testimonial-author">
                            <img src="https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?q=80&w=150" alt="Member Avatar" class="testimonial-avatar">
                            <div>
                                <div class="testimonial-name">Hoàng Long</div>
                                <div class="testimonial-pkg"><?php echo __('Gói Gold 3 Tháng'); ?></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="testimonial-card h-100 d-flex flex-column justify-content-between">
                        <div>
                            <div class="testimonial-stars">
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                            </div>
                            <p class="testimonial-quote">
                                "<?php echo __('Rất hài lòng với chất lượng dịch vụ của GymPro. Các gói tập linh hoạt, không phát sinh chi phí ẩn. Hợp đồng rõ ràng và PT hỗ trợ đắc lực.'); ?>"
                            </p>
                        </div>
                        <div class="testimonial-author">
                            <img src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?q=80&w=150" alt="Member Avatar" class="testimonial-avatar">
                            <div>
                                <div class="testimonial-name">Khánh Linh</div>
                                <div class="testimonial-pkg"><?php echo __('Gói Diamond 12 Tháng'); ?></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Latest News Section -->
    <section id="news" class="py-5 my-5">
        <div class="container">
            <div class="section-header text-center">
                <span class="section-tag"><?php echo __('Cập nhật mới nhất'); ?></span>
                <h2 class="section-title-text text-dark"><?php echo __('Tin Tức & Sự Kiện Nổi Bật'); ?></h2>
                <p class="text-muted mx-auto mt-3" style="max-width: 600px;">
                    <?php echo __('Theo dõi các tin tức thể hình, dinh dưỡng chia sẻ từ các chuyên gia hàng đầu và thông tin sự kiện mới nhất tại GymPro.'); ?>
                </p>
            </div>
            <div class="row g-4">
                @foreach($articles ?? [] as $article)
                    <div class="col-lg-4 col-md-6">
                        <div class="news-card">
                            <div class="news-img-box">
                                <span class="news-cat-badge">{{ $article['category'] }}</span>
                                <img src="{{ $article['image'] }}" alt="{{ $article['title'] }}" class="news-img">
                            </div>
                            <div class="news-body">
                                <div class="news-date"><i class="bi bi-calendar3 me-2"></i>{{ $article['date'] }}</div>
                                <h3 class="news-title">
                                    <a href="<?php echo route('news'); ?>">{{ $article['title'] }}</a>
                                </h3>
                                <p class="news-excerpt">{{ $article['summary'] }}</p>
                                <a href="<?php echo route('news'); ?>" class="news-link"><?php echo __('Xem chi tiết'); ?> <i class="bi bi-arrow-right-short"></i></a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Pricing Packages Section -->
    <section id="pricing" class="py-5">
        <div class="container">
            <div class="section-header text-center">
                <span class="section-tag">Thành viên GymPro</span>
                <h2 class="section-title-text text-dark">Gói Tập Membership Phổ Biến</h2>
                <p class="text-muted mx-auto mt-3" style="max-width: 600px;">Bắt đầu tập luyện ngay hôm nay với mức phí hợp lý, cam kết không phát sinh phụ phí.</p>
            </div>

            @if(count($packages) === 0)
                <div class="text-center py-5">
                    <i class="bi bi-box-seam text-muted" style="font-size: 3rem; opacity: 0.3;"></i>
                    <p class="text-muted mt-3">Đang cập nhật các gói tập dịch vụ...</p>
                </div>
            @else
                <div class="row g-4 justify-content-center">
                    @foreach($packages as $pkg)
                        @php 
                            $isPopular = str_contains(strtolower($pkg['name']), 'vip') || $pkg['duration'] >= 180;
                        @endphp
                        <div class="col-lg-4 col-md-6">
                            <div class="pkg-card {{ $isPopular ? 'premium' : '' }}">
                                <div>
                                    <h3 class="pkg-name">{{ $pkg['name'] }}</h3>
                                    <div class="badge bg-light text-muted border px-3 py-1 rounded-pill small">Thời hạn: {{ $pkg['duration'] }} ngày</div>
                                    
                                    <div class="pkg-price-box">
                                        <div class="pkg-price">{{ number_format($pkg['price'], 0, ',', '.') }}<span>₫</span></div>
                                        <div class="text-muted small mt-1">Hội viên hoạt động: {{ $pkg['activeSubscriptions'] ?? 0 }}</div>
                                    </div>

                                    @if($pkg['description'])
                                        <p class="text-muted small my-3">{{ $pkg['description'] }}</p>
                                    @endif

                                    @if($pkg['features'])
                                        <ul class="pkg-features">
                                            @foreach(explode(',', $pkg['features']) as $feat)
                                                <li><i class="bi bi-check-circle-fill"></i> {{ trim($feat) }}</li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </div>
                                <a href="{{ route('login') }}" class="btn-pkg mt-auto">Đăng ký Ngay</a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </section>

    <!-- Call to Action Banner -->
    <section class="container mb-5">
        <div class="cta-banner">
            <h2 class="display-4 fw-bold text-dark mb-3">Sẵn Sàng Thay Đổi Bản Thân?</h2>
            <p class="text-muted mx-auto mb-4" style="max-width: 600px; font-size: 1.1rem;">
                Tham gia GYMPRO ngay hôm nay để trải nghiệm hệ sinh thái tập luyện thông minh với sự hướng dẫn từ các PT chuyên nghiệp.
            </p>
            <div class="d-flex justify-content-center gap-3">
                <a href="{{ route('register') }}" class="btn-red-glow">
                    Đăng Ký Tài Khoản Mới <i class="bi bi-person-plus-fill ms-2"></i>
                </a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="row g-4 mb-5">
                <div class="col-lg-4">
                    <div class="footer-logo">
                        <i class="bi bi-lightning-charge-fill" style="color: var(--primary-red);"></i> GYM<span>PRO</span>
                    </div>
                    <p class="text-muted pe-3">Hệ thống quản lý phòng gym cao cấp và tối ưu sức khỏe hội viên bằng công nghệ tự động hóa.</p>
                </div>
                <div class="col-lg-4">
                    <h5 class="fw-bold text-white mb-3" style="font-size: 0.75rem; letter-spacing: 1.5px; text-transform: uppercase;">Điều Hướng</h5>
                    <ul class="footer-links">
                        <li><a href="{{ route('home') }}">Trang Chủ</a></li>
                        <li><a href="{{ route('about') }}">Giới Thiệu</a></li>
                        <li><a href="{{ route('news') }}">Tin Tức</a></li>
                        <li><a href="{{ route('contact') }}">Liên Hệ</a></li>
                    </ul>
                </div>
                <div class="col-lg-4">
                    <h5 class="fw-bold text-white mb-3" style="font-size: 0.75rem; letter-spacing: 1.5px; text-transform: uppercase;">Hỗ Trợ</h5>
                    <p class="mb-2 text-muted"><i class="bi bi-telephone-fill me-2 text-white"></i> Hotline: 1900 6868</p>
                    <p class="mb-2 text-muted"><i class="bi bi-envelope-fill me-2 text-white"></i> Email: support@gympro.com</p>
                    <p class="mb-0 text-muted"><i class="bi bi-geo-alt-fill me-2 text-white"></i> HQ: Quận 1, TP. Hồ Chí Minh</p>
                </div>
            </div>
            <div class="border-top border-secondary pt-4 text-center">
                <p class="mb-0 small">© 2026 GYMPRO Intelligent Gym Management System. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- JS Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Navbar scrolled background change
        window.addEventListener('scroll', function() {
            const navbar = document.getElementById('mainNavbar');
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });
    </script>
</body>

</html>