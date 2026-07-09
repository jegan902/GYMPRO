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
            /* -webkit-background-clip: text; */
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
                        Kiến Tạo<br>Vóc Dáng <span>Vượt Trội</span>
                    </h1>
                    <p class="hero-lead">
                        Hệ thống GymPro liên kết trực tiếp các chi nhánh, đồng bộ quản lý đội ngũ PT huấn luyện và tích hợp AI phân tích chỉ số cơ thể thời gian thực giúp bạn đạt hiệu quả tối ưu nhất.
                    </p>
                    <div class="d-flex flex-wrap gap-3">
                        @if(session('api_token'))
                            <a href="{{ route('admin.dashboard') }}" class="btn-red-glow">
                                TRUY CẬP DASHBOARD <i class="bi bi-chevron-right"></i>
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="btn-red-glow">
                                BẮT ĐẦU NGAY <i class="bi bi-lightning-fill"></i>
                            </a>
                        @endif
                        <a href="#branches" class="btn-outline-minimal">Tìm chi nhánh gần nhất</a>
                    </div>
                </div>
                <div>
                    <div class="hero-poster-container">
                        <img src="https://images.unsplash.com/photo-1517838277536-f5f99be501cd?q=80&w=1000" 
                             alt="Workout Fitness" class="hero-poster-img">
                        <div class="hero-poster-overlay">
                            <span class="role-badge badge-mgr mb-2 w-auto align-self-start" style="font-size: 0.6rem;">HIGH INTENSITY</span>
                            <h4 class="fw-bold text-white mb-1 uppercase">LIMITLESS POTENTIAL</h4>
                            <p class="text-muted small mb-0">Hệ thống phân quyền chi tiết cho Quản lý chi nhánh (Branch Admin) và Nhân viên (Staff/PT).</p>
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
                    <span class="intro-tagline">Về chúng tôi</span>
                    <h2 class="intro-title">Chào mừng bạn đến với GymPro</h2>
                    <p class="intro-desc">
                        GymPro không chỉ đơn thuần là một trung tâm thể hình. Chúng tôi là một <strong>hệ sinh thái tập luyện thông minh và toàn diện</strong>. Với định hướng mang lại trải nghiệm cao cấp nhưng vô cùng dễ tiếp cận, GymPro kết hợp hài hòa giữa không gian tập luyện hiện đại, đội ngũ huấn luyện viên (PT) chuyên nghiệp và hệ thống phân tích chỉ số sức khỏe AI thời gian thực. Bất kể bạn là người mới bắt đầu hay vận động viên chuyên nghiệp, chúng tôi cam kết hỗ trợ bạn trên từng bước hành trình chinh phục mục tiêu sức khỏe.
                    </p>
                    
                    <!-- Approachable Trust Metrics -->
                    <div class="intro-stats-grid">
                        <div class="intro-stat-card">
                            <div class="intro-stat-number">15+</div>
                            <div class="intro-stat-label">Chi nhánh</div>
                        </div>
                        <div class="intro-stat-card">
                            <div class="intro-stat-number">50K+</div>
                            <div class="intro-stat-label">Hội viên</div>
                        </div>
                        <div class="intro-stat-card">
                            <div class="intro-stat-number">98%</div>
                            <div class="intro-stat-label">Hài lòng</div>
                        </div>
                    </div>

                    <!-- Highlight Features -->
                    <ul class="intro-features-list">
                        <li><i class="bi bi-patch-check-fill"></i> Đội ngũ Huấn luyện viên chuyên môn cao, hỗ trợ tận tâm.</li>
                        <li><i class="bi bi-patch-check-fill"></i> Đo lường & đề xuất chế độ dinh dưỡng cá nhân hóa bằng AI.</li>
                        <li><i class="bi bi-patch-check-fill"></i> Trang thiết bị nhập khẩu 100% đạt chuẩn Olympic.</li>
                    </ul>

                    <a href="{{ route('about') }}" class="btn-red-glow">Xem Chi Tiết Giới Thiệu <i class="bi bi-arrow-right-short ms-1"></i></a>
                    <a href="#branches" class="btn-outline-minimal ms-2">Khám phá chi nhánh</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Smart Features Section -->
    <section id="features" class="py-5">
        <div class="container">
            <div class="section-header text-center">
                <span class="section-tag">Công nghệ tối tân</span>
                <h2 class="section-title-text text-dark">Smart Fitness Ecosystem</h2>
                <p class="text-muted mx-auto mt-3" style="max-width: 600px;">Được thiết kế để tối ưu hóa quy trình vận hành và nâng cao trải nghiệm tập luyện của hội viên.</p>
            </div>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="premium-card h-100">
                        <div class="feature-num">01</div>
                        <h4 class="fw-bold mb-3 text-dark">Tính toán Chỉ số Tự động</h4>
                        <p class="text-muted mb-0">Hệ thống tự động phân tích chỉ số BMI, BMR, TDEE ngay khi ghi nhận số đo của hội viên để đề xuất chế độ ăn uống.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="premium-card h-100">
                        <div class="feature-num" style="--primary-red: #2E90FF;">02</div>
                        <h4 class="fw-bold mb-3 text-dark">Phân Quyền Vai Trò CMS</h4>
                        <p class="text-muted mb-0">Hệ thống phân quyền chi tiết cho Quản lý chi nhánh (Branch Admin) và Nhân viên (Staff/PT) để kiểm soát dữ liệu chặt chẽ.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="premium-card h-100">
                        <div class="feature-num" style="--primary-red: #10B981;">03</div>
                        <h4 class="fw-bold mb-3 text-dark">Báo cáo & Cảnh báo Sức khỏe</h4>
                        <p class="text-muted mb-0">Kết nối trực tiếp IoT và AI để liên tục cập nhật và cảnh báo các chỉ số bất thường khi tập luyện.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- AI BMI / BMR Calculator Tool (WOW Preview Section) -->
    <section id="bmr-tool" class="py-5 my-5">
        <div class="container">
            <div class="row align-items-center g-5">
                <div class="col-lg-5">
                    <span class="section-tag">AI health tool</span>
                    <h2 class="section-title-text text-dark mb-4">Ước tính thể trạng thời gian thực</h2>
                    <p class="text-muted mb-4">
                        Nhập nhanh số đo chiều cao và cân nặng để xem chỉ số BMI (Body Mass Index) và BMR (Tỷ lệ trao đổi chất cơ bản) của bạn dựa trên thuật toán AI GymPro.
                    </p>
                    <div class="p-3 bg-warning bg-opacity-10 border border-warning-subtle rounded mb-4">
                        <div class="small text-muted"><i class="bi bi-info-circle-fill text-warning me-2"></i><strong>Lưu ý:</strong> Để lưu trữ lịch sử, theo dõi biểu đồ tăng trưởng sức khỏe định kỳ và nhận thực đơn đề xuất cá nhân hóa, vui lòng đăng nhập vào tài khoản hội viên.</div>
                    </div>
                    <a href="{{ route('login') }}" class="btn-outline-minimal">ĐĂNG NHẬP LƯU CHỈ SỐ <i class="bi bi-arrow-right-short ms-2"></i></a>
                </div>
                <div class="col-lg-7">
                    <div class="analytics-preview-widget">
                        <div class="row g-4">
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <label class="calc-label">Chiều cao (cm)</label>
                                    <input type="number" id="inputHeight" class="calc-input" placeholder="Ví dụ: 175" value="170">
                                </div>
                                <div class="mb-4">
                                    <label class="calc-label">Cân nặng (kg)</label>
                                    <input type="number" id="inputWeight" class="calc-input" placeholder="Ví dụ: 70" value="65">
                                </div>
                                <button onclick="calculateAIStats()" class="btn-red-glow w-100 py-3 d-block text-center justify-content-center">Phân tích thể trạng</button>
                            </div>
                            <div class="col-md-6 text-center d-flex flex-column justify-content-center">
                                <div class="circular-progress-box mb-3">
                                    <svg>
                                        <circle class="circular-bg" cx="90" cy="90" r="70"></circle>
                                        <circle class="circular-bar" id="bmiCircle" cx="90" cy="90" r="70"></circle>
                                    </svg>
                                    <div class="circular-value">
                                        <div class="h3 fw-bold text-dark mb-0" id="bmiVal">22.5</div>
                                        <div class="small text-muted font-monospace" style="font-size: 0.65rem;">BMI</div>
                                    </div>
                                </div>
                                <div class="fw-bold text-dark" id="statusVal">Thể trạng: Bình Thường</div>
                                <div class="text-muted small mt-2" id="bmrVal">BMR dự tính: 1,485 kcal/ngày</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Branch CMS Portal Dynamic Section -->
    <section id="branches" class="py-5">
        <div class="container">
            <div class="section-header text-center">
                <span class="section-tag">Đồng bộ dữ liệu CMS</span>
                <h2 class="section-title-text text-dark">Khám Phá Chi Nhánh & Đội Ngũ Nhân Sự</h2>
                <p class="text-muted mx-auto mt-3" style="max-width: 600px;">Dữ liệu nhân sự được đồng bộ thời gian thực từ hệ thống CMS của các Quản lý chi nhánh & Nhân viên.</p>
            </div>

            @if(count($branches) === 0)
                <div class="text-center py-5">
                    <i class="bi bi-geo text-muted" style="font-size: 3rem; opacity: 0.3;"></i>
                    <p class="text-muted mt-3">Đang cập nhật danh sách chi nhánh từ CMS...</p>
                </div>
            @else
                <!-- Branch Selector Tab Buttons -->
                <div class="branch-tabs">
                    @foreach($branches ?? [] as $index => $branch)
                        @php
                            $bId = data_get($branch, 'id') ?? data_get($branch, 'Id');
                            $bName = data_get($branch, 'name') ?? data_get($branch, 'Name');
                        @endphp
                        <button class="branch-tab-btn {{ $index === 0 ? 'active' : '' }}" onclick="switchBranch(event, 'branch-tab-{{ $bId }}')">
                            <i class="bi bi-geo-alt-fill me-2"></i> {{ $bName }}
                        </button>
                    @endforeach
                </div>

                <!-- Branch Contents -->
                @foreach($branches ?? [] as $index => $branch)
                    @php
                        $bId = data_get($branch, 'id') ?? data_get($branch, 'Id');
                        $bName = data_get($branch, 'name') ?? data_get($branch, 'Name');
                        $bAddress = data_get($branch, 'address') ?? data_get($branch, 'Address');
                        $bPhone = data_get($branch, 'phone') ?? data_get($branch, 'Phone');
                        $bMembersCount = data_get($branch, 'members_count') ?? data_get($branch, 'MembersCount') ?? 0;
                        $bIsActive = data_get($branch, 'is_active') ?? data_get($branch, 'IsActive');
                        $bManager = data_get($branch, 'manager') ?? data_get($branch, 'Manager');
                        $bManagerAvatar = data_get($branch, 'manager_avatar') ?? data_get($branch, 'ManagerAvatar');
                    @endphp
                    <div class="branch-content-panel {{ $index === 0 ? '' : 'd-none' }}" id="branch-tab-{{ $bId }}">
                        <div class="branch-portal-grid">
                            <!-- Left: Branch details -->
                            <div class="premium-card d-flex flex-column justify-content-between">
                                <div>
                                    <h3 class="fw-bold text-dark mb-4"><i class="bi bi-building-fill text-danger me-2"></i>{{ $bName }}</h3>
                                    
                                    <div class="branch-meta-item">
                                        <div class="branch-meta-icon"><i class="bi bi-map"></i></div>
                                        <div>
                                            <div class="small text-muted fw-bold text-uppercase" style="font-size: 0.65rem; letter-spacing: 1px;">Địa chỉ</div>
                                            <div class="text-dark fw-bold">{{ $bAddress }}</div>
                                        </div>
                                    </div>

                                    <div class="branch-meta-item">
                                        <div class="branch-meta-icon"><i class="bi bi-telephone"></i></div>
                                        <div>
                                            <div class="small text-muted fw-bold text-uppercase" style="font-size: 0.65rem; letter-spacing: 1px;">Hotline chi nhánh</div>
                                            <div class="text-dark fw-bold">{{ $bPhone ?? 'Chưa cập nhật' }}</div>
                                        </div>
                                    </div>

                                    <div class="branch-meta-item">
                                        <div class="branch-meta-icon"><i class="bi bi-people"></i></div>
                                        <div>
                                            <div class="small text-muted fw-bold text-uppercase" style="font-size: 0.65rem; letter-spacing: 1px;">Hội viên hoạt động</div>
                                            <div class="text-dark fw-bold">{{ $bMembersCount }} hội viên</div>
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-4 pt-3 border-top border-secondary d-flex align-items-center justify-content-between">
                                    <span class="small text-muted">Trạng thái CMS</span>
                                    @if($bIsActive)
                                        <span class="badge bg-success px-3 py-2 rounded-pill"><i class="bi bi-check-circle-fill me-1"></i> Đang mở cửa</span>
                                    @else
                                        <span class="badge bg-secondary px-3 py-2 rounded-pill"><i class="bi bi-dash-circle-fill me-1"></i> Đang bảo trì</span>
                                    @endif
                                </div>
                            </div>

                            <!-- Right: Branch Personnel from CMS Roles -->
                            <div class="premium-card">
                                <!-- Manager of Branch (Branch Admin Role) -->
                                <div class="staff-section-title">
                                    Quản lý chi nhánh (Branch Admin)
                                </div>
                                <div class="manager-card mb-5">
                                    <img src="{{ $bManagerAvatar ?? 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?q=80&w=200' }}" 
                                         alt="Manager Avatar" class="staff-avatar">
                                    <div>
                                        <h4 class="fw-bold text-dark mb-1">{{ $bManager }}</h4>
                                        <span class="role-badge badge-mgr mb-2">Branch Admin / Manager</span>
                                        <div class="text-muted small"><i class="bi bi-envelope me-2"></i>Dữ liệu quản trị được chỉ định chính thức từ CMS.</div>
                                    </div>
                                </div>

                                <!-- Staff/PT list belonging to this branch -->
                                <div class="staff-section-title">
                                    Đội ngũ huấn luyện viên (Staff / PT)
                                </div>
                                
                                @php
                                    $branchStaff = collect($staff)->filter(function($u) use ($bId) {
                                        return data_get($u, 'branch_id') == $bId && in_array(data_get($u, 'role_name'), ['Staff/PT', 'PT', 'Staff']);
                                    });
                                @endphp

                                @if($branchStaff->isEmpty())
                                    <div class="text-center py-5 bg-light bg-opacity-50 rounded border border-secondary border-dashed">
                                        <i class="bi bi-person-x text-muted fs-2"></i>
                                        <p class="text-muted small mt-2 mb-0">Chưa có PT nào được phân bổ cho chi nhánh này trên CMS.</p>
                                    </div>
                                @else
                                    <div class="staff-grid">
                                        @foreach($branchStaff as $pt)
                                            @php
                                                $ptAvatar = data_get($pt, 'avatar');
                                                $ptFullName = data_get($pt, 'full_name');
                                                $ptEmail = data_get($pt, 'email');
                                            @endphp
                                            <div class="staff-card">
                                                <img src="{{ $ptAvatar ?? 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?q=80&w=200' }}" 
                                                     alt="PT Avatar" class="staff-avatar">
                                                <h5 class="fw-bold text-dark mb-1" style="font-size: 1.05rem;">{{ $ptFullName }}</h5>
                                                <span class="role-badge badge-pt mb-2">Personal Trainer</span>
                                                <div class="text-muted small" style="font-size: 0.75rem;"><i class="bi bi-envelope-fill me-1"></i>{{ $ptEmail }}</div>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
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

        // Switch branch tabs
        function switchBranch(evt, branchId) {
            // Hide all panels
            const panels = document.querySelectorAll('.branch-content-panel');
            panels.forEach(p => p.classList.add('d-none'));

            // Deactivate all buttons
            const buttons = document.querySelectorAll('.branch-tab-btn');
            buttons.forEach(b => b.classList.remove('active'));

            // Show current panel and activate current button
            document.getElementById(branchId).classList.remove('d-none');
            evt.currentTarget.classList.add('active');
        }

        // AI Health tool calculation logic
        function calculateAIStats() {
            const height = parseFloat(document.getElementById('inputHeight').value) / 100;
            const weight = parseFloat(document.getElementById('inputWeight').value);

            if (!height || !weight || height <= 0 || weight <= 0) {
                alert('Vui lòng nhập chiều cao và cân nặng hợp lệ.');
                return;
            }

            const bmi = (weight / (height * height)).toFixed(1);
            document.getElementById('bmiVal').innerText = bmi;

            // BMR estimate (Harris-Benedict for males as baseline)
            const bmr = Math.round(88.362 + (13.397 * weight) + (4.799 * (height * 100)) - (5.677 * 25));
            document.getElementById('bmrVal').innerText = `BMR dự tính: ${bmr.toLocaleString()} kcal/ngày`;

            let status = 'Bình Thường';
            let strokeOffset = 440 - (440 * 0.75); // baseline for 75%
            
            if (bmi < 18.5) {
                status = 'Gầy';
                document.getElementById('bmiVal').style.color = '#38BDF8';
                strokeOffset = 440 - (440 * (bmi / 40));
            } else if (bmi >= 18.5 && bmi < 25) {
                status = 'Bình Thường';
                document.getElementById('bmiVal').style.color = '#10B981';
                strokeOffset = 440 - (440 * (bmi / 40));
            } else if (bmi >= 25 && bmi < 30) {
                status = 'Thừa Cân';
                document.getElementById('bmiVal').style.color = '#F59E0B';
                strokeOffset = 440 - (440 * (bmi / 40));
            } else {
                status = 'Béo Phì';
                document.getElementById('bmiVal').style.color = '#EF4444';
                strokeOffset = 440 - (440 * (bmi / 40));
            }

            document.getElementById('statusVal').innerText = `Thể trạng: ${status}`;
            
            const circle = document.getElementById('bmiCircle');
            circle.style.strokeDashoffset = strokeOffset;
        }

        // Trigger initial calculation
        calculateAIStats();
    </script>
</body>

</html>