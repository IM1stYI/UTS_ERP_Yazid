<?php
// Penjaga sesi sisi server (sesi sama dengan api/api.php)
session_name('ERPSESS');
session_start();
if (empty($_SESSION['user'])) { header('Location: login.php'); exit; }
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Portal Praktikum ERP (1 - 5) | Politeknik META Industri</title>
  <meta name="description" content="Aplikasi Praktikum Terpadu Enterprise Resource Planning - TRPL Politeknik META Industri">
  <!-- Modern, Comfortable Typography -->
  <link rel="stylesheet" href="fonts/fonts.css">
  <!-- Stylesheet -->
  <style>
/* ==========================================================================
   META ERP SUITE - POLITEKNIK META INDUSTRI
   Clean, Friendly & Minimalist Modern Design System
   Designed for Clarity, Comfort, and Detailed Academics
   ========================================================================== */

:root {
  /* Soft, Friendly Color Palette */
  --brand-primary: #3b82f6;       /* Clean blue */
  --brand-primary-hover: #2563eb;
  --brand-primary-light: #eff6ff;
  --brand-primary-dark: #1d4ed8;

  --accent-indigo: #6366f1;
  --accent-indigo-light: #eef2ff;

  --success: #10b981;
  --success-light: #ecfdf5;
  --success-dark: #047857;

  --warning: #f59e0b;
  --warning-light: #fffbeb;
  --warning-dark: #b45309;

  --danger: #ef4444;
  --danger-light: #fef2f2;
  --danger-dark: #b91c1c;

  /* Neutral Slates (Comfortable for the eyes) */
  --bg-body: #f8fafc;
  --bg-card: #ffffff;
  --bg-card-subtle: #f1f5f9;
  --bg-hover: #f8fafc;

  --text-main: #1e293b;          /* Soft dark slate, not harsh pitch black */
  --text-muted: #64748b;         /* Neutral slate for descriptions */
  --text-light: #94a3b8;

  --border-subtle: #e2e8f0;
  --border-focus: #3b82f6;

  /* Typography */
  --font-sans: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
  --font-mono: 'JetBrains Mono', 'Fira Code', monospace;

  /* Shadows */
  --shadow-xs: 0 1px 2px rgba(0, 0, 0, 0.04);
  --shadow-sm: 0 1px 3px rgba(0, 0, 0, 0.06), 0 1px 2px rgba(0, 0, 0, 0.04);
  --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.07), 0 2px 4px -1px rgba(0, 0, 0, 0.04);
  --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.06), 0 4px 6px -2px rgba(0, 0, 0, 0.03);

  /* Radius */
  --radius-sm: 8px;
  --radius-md: 12px;
  --radius-lg: 16px;
  --radius-full: 9999px;
}

/* Reset & Base */
*, *::before, *::after {
  box-sizing: border-box;
  margin: 0;
  padding: 0;
}

body {
  font-family: var(--font-sans);
  background-color: var(--bg-body);
  color: var(--text-main);
  line-height: 1.6;
  -webkit-font-smoothing: antialiased;
  min-height: 100vh;
  display: flex;
  flex-direction: column;
}

/* ==========================================================================
   Header & Clean Navigation
   ========================================================================== */
.site-header {
  position: sticky;
  top: 0;
  z-index: 90;
  background: rgba(255, 255, 255, 0.95);
  backdrop-filter: blur(10px);
  border-bottom: 1px solid var(--border-subtle);
  box-shadow: var(--shadow-xs);
}

.header-container {
  max-width: 1320px;
  margin: 0 auto;
  padding: 12px 24px;
  display: flex;
  justify-content: space-between;
  align-items: center;
  gap: 16px;
}

.brand-section {
  display: flex;
  align-items: center;
  gap: 12px;
  cursor: pointer;
}

.brand-icon-box {
  width: 42px;
  height: 42px;
  border-radius: var(--radius-md);
  background: linear-gradient(135deg, #2563eb, #1d4ed8);
  display: flex;
  align-items: center;
  justify-content: center;
  color: #fff;
  box-shadow: 0 2px 6px rgba(37, 99, 235, 0.25);
  flex-shrink: 0;
}

.brand-meta h1 {
  font-size: 1.05rem;
  font-weight: 800;
  color: var(--text-main);
  line-height: 1.2;
}

.brand-meta p {
  font-size: 0.75rem;
  color: var(--text-muted);
  font-weight: 500;
}

/* Primary Top Navigation Tabs */
.nav-pills {
  display: flex;
  align-items: center;
  gap: 6px;
  background: var(--bg-card-subtle);
  padding: 4px;
  border-radius: var(--radius-full);
  border: 1px solid var(--border-subtle);
}

.nav-pill-btn {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  padding: 7px 14px;
  border: none;
  background: transparent;
  color: var(--text-muted);
  font-family: inherit;
  font-size: 0.84rem;
  font-weight: 600;
  border-radius: var(--radius-full);
  cursor: pointer;
  transition: all 0.18s ease;
  white-space: nowrap;
}

.nav-pill-btn:hover {
  color: var(--text-main);
  background: rgba(255, 255, 255, 0.7);
}

.nav-pill-btn.active {
  background: #ffffff;
  color: var(--brand-primary);
  box-shadow: var(--shadow-sm);
  font-weight: 700;
}

.nav-pill-btn .pill-num {
  width: 20px;
  height: 20px;
  border-radius: 50%;
  background: var(--border-subtle);
  color: var(--text-muted);
  font-size: 0.72rem;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  font-weight: 700;
}

.nav-pill-btn.active .pill-num {
  background: var(--brand-primary);
  color: #ffffff;
}

.header-right {
  display: flex;
  align-items: center;
  gap: 12px;
}

.btn-print {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  background: #ffffff;
  border: 1px solid var(--border-subtle);
  color: var(--text-muted);
  font-family: inherit;
  font-size: 0.8rem;
  font-weight: 600;
  padding: 7px 12px;
  border-radius: var(--radius-sm);
  cursor: pointer;
  transition: all 0.15s ease;
}

.btn-print:hover {
  background: var(--bg-hover);
  color: var(--text-main);
  border-color: #cbd5e1;
}

/* ==========================================================================
   Main Application Layout
   ========================================================================== */
.main-wrapper {
  max-width: 1320px;
  width: 100%;
  margin: 0 auto;
  padding: 24px 24px 60px;
  flex: 1;
}

.tab-pane {
  display: none;
  animation: gentleFadeIn 0.25s ease-out;
}

.tab-pane.active {
  display: block;
}

@keyframes gentleFadeIn {
  from {
    opacity: 0;
    transform: translateY(4px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

/* ==========================================================================
   Beranda (Home Hub)
   ========================================================================== */
.welcome-hero {
  background: #ffffff;
  border: 1px solid var(--border-subtle);
  border-radius: var(--radius-lg);
  padding: 32px 36px;
  margin-bottom: 28px;
  box-shadow: var(--shadow-sm);
  position: relative;
  overflow: hidden;
}

.welcome-hero::after {
  content: '';
  position: absolute;
  top: 0;
  right: 0;
  width: 320px;
  height: 100%;
  background: linear-gradient(135deg, rgba(59, 130, 246, 0.05) 0%, rgba(99, 102, 241, 0.08) 100%);
  border-radius: 0 var(--radius-lg) var(--radius-lg) 0;
  pointer-events: none;
}

.hero-pill-badge {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  background: var(--brand-primary-light);
  color: var(--brand-primary-dark);
  font-size: 0.78rem;
  font-weight: 700;
  padding: 4px 12px;
  border-radius: var(--radius-full);
  margin-bottom: 12px;
}

.welcome-hero h2 {
  font-size: 1.75rem;
  font-weight: 800;
  color: var(--text-main);
  letter-spacing: -0.4px;
  margin-bottom: 8px;
}

.welcome-hero p.lead {
  font-size: 0.96rem;
  color: var(--text-muted);
  max-width: 820px;
  line-height: 1.6;
  margin-bottom: 20px;
}

.hero-stats-row {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
  gap: 16px;
  padding-top: 18px;
  border-top: 1px solid var(--border-subtle);
}

.stat-item {
  display: flex;
  flex-direction: column;
}

.stat-label {
  font-size: 0.72rem;
  text-transform: uppercase;
  color: var(--text-light);
  font-weight: 700;
  letter-spacing: 0.5px;
}

.stat-val {
  font-size: 0.92rem;
  font-weight: 700;
  color: var(--text-main);
  margin-top: 2px;
}

/* Practicum Cards Grid */
.home-section-title {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 18px;
}

.home-section-title h3 {
  font-size: 1.25rem;
  font-weight: 700;
  color: var(--text-main);
}

.cards-container {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
  gap: 20px;
  margin-bottom: 28px;
}

.course-card {
  background: #ffffff;
  border: 1px solid var(--border-subtle);
  border-radius: var(--radius-md);
  padding: 22px;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
  box-shadow: var(--shadow-xs);
  transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
  cursor: pointer;
  position: relative;
}

.course-card:hover {
  transform: translateY(-3px);
  box-shadow: var(--shadow-md);
  border-color: #cbd5e1;
}

.card-top {
  display: flex;
  align-items: center;
  gap: 10px;
  margin-bottom: 12px;
}

.card-icon {
  width: 36px;
  height: 36px;
  border-radius: var(--radius-sm);
  background: var(--card-color-bg, #eff6ff);
  color: var(--card-color, #3b82f6);
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 1rem;
  font-weight: 800;
  flex-shrink: 0;
}

.card-num-text {
  font-size: 0.75rem;
  font-weight: 700;
  color: var(--text-light);
  text-transform: uppercase;
}

.card-content h4 {
  font-size: 1.05rem;
  font-weight: 700;
  color: var(--text-main);
  margin-bottom: 6px;
  line-height: 1.35;
}

.card-content p {
  font-size: 0.84rem;
  color: var(--text-muted);
  line-height: 1.5;
  margin-bottom: 16px;
}

.card-action {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding-top: 12px;
  border-top: 1px solid var(--border-subtle);
  font-size: 0.82rem;
  font-weight: 700;
  color: var(--card-color, #3b82f6);
}

/* ==========================================================================
   Practicum Views & Sub-Tabs Architecture
   (This organizes details cleanly so the UI is pleasant and easy to digest)
   ========================================================================== */
.module-banner {
  background: #ffffff;
  border: 1px solid var(--border-subtle);
  border-radius: var(--radius-md);
  padding: 20px 24px;
  margin-bottom: 20px;
  display: flex;
  justify-content: space-between;
  align-items: center;
  box-shadow: var(--shadow-xs);
}

.module-info {
  display: flex;
  align-items: center;
  gap: 14px;
}

.module-badge-num {
  width: 44px;
  height: 44px;
  border-radius: var(--radius-sm);
  background: var(--module-accent, #3b82f6);
  color: #ffffff;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 1.15rem;
  font-weight: 800;
}

.module-info h2 {
  font-size: 1.25rem;
  font-weight: 800;
  color: var(--text-main);
}

.module-info p {
  font-size: 0.84rem;
  color: var(--text-muted);
}

/* Sub-Tab Navigation Bar */
.subtabs-bar {
  display: flex;
  gap: 8px;
  background: var(--bg-card-subtle);
  padding: 6px;
  border-radius: var(--radius-md);
  border: 1px solid var(--border-subtle);
  margin-bottom: 20px;
  overflow-x: auto;
}

.subtab-btn {
  padding: 8px 16px;
  border: none;
  background: transparent;
  color: var(--text-muted);
  font-family: inherit;
  font-size: 0.84rem;
  font-weight: 600;
  border-radius: var(--radius-sm);
  cursor: pointer;
  transition: all 0.15s ease;
  white-space: nowrap;
}

.subtab-btn:hover {
  color: var(--text-main);
  background: rgba(255, 255, 255, 0.6);
}

.subtab-btn.active {
  background: #ffffff;
  color: var(--brand-primary-dark);
  font-weight: 700;
  box-shadow: var(--shadow-xs);
}

/* Sub-tab Pane Visibility */
.subtab-content {
  display: none;
  animation: gentleFadeIn 0.2s ease;
}

.subtab-content.active {
  display: block;
}

/* ==========================================================================
   Clean Card Components, Tables & Utilities
   ========================================================================== */
.clean-card {
  background: #ffffff;
  border: 1px solid var(--border-subtle);
  border-radius: var(--radius-md);
  padding: 24px;
  margin-bottom: 20px;
  box-shadow: var(--shadow-xs);
}

.card-title-bar {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 16px;
  padding-bottom: 12px;
  border-bottom: 1px solid var(--border-subtle);
}

.card-title-bar h3 {
  font-size: 1.05rem;
  font-weight: 700;
  color: var(--text-main);
}

/* Clean Tables */
.table-wrap {
  width: 100%;
  overflow-x: auto;
  border: 1px solid var(--border-subtle);
  border-radius: var(--radius-sm);
}

.clean-table {
  width: 100%;
  border-collapse: collapse;
  font-size: 0.85rem;
  text-align: left;
}

.clean-table th {
  background: #f8fafc;
  color: var(--text-muted);
  font-weight: 700;
  padding: 10px 14px;
  border-bottom: 1px solid var(--border-subtle);
  white-space: nowrap;
}

.clean-table td {
  padding: 12px 14px;
  border-bottom: 1px solid var(--border-subtle);
  color: var(--text-main);
  vertical-align: middle;
}

.clean-table tbody tr:last-child td {
  border-bottom: none;
}

.clean-table tbody tr:hover {
  background: #fbfcfe;
}

/* Badges */
.tag {
  display: inline-flex;
  align-items: center;
  gap: 4px;
  font-size: 0.74rem;
  font-weight: 600;
  padding: 3px 8px;
  border-radius: var(--radius-full);
}

.tag-blue {
  background: #eff6ff;
  color: #1d4ed8;
}

.tag-green {
  background: #ecfdf5;
  color: #047857;
}

.tag-amber {
  background: #fffbeb;
  color: #b45309;
}

.tag-red {
  background: #fef2f2;
  color: #b91c1c;
}

.tag-gray {
  background: #f1f5f9;
  color: #475569;
}

/* Clean Callout Boxes */
.clean-callout {
  padding: 14px 18px;
  border-radius: var(--radius-sm);
  margin-bottom: 18px;
  font-size: 0.86rem;
  line-height: 1.5;
  border-left: 3px solid;
}

.callout-blue {
  background: #eff6ff;
  border-left-color: #3b82f6;
  color: #1e40af;
}

.callout-green {
  background: #ecfdf5;
  border-left-color: #10b981;
  color: #065f46;
}

.callout-amber {
  background: #fffbeb;
  border-left-color: #f59e0b;
  color: #92400e;
}

.callout-red {
  background: #fef2f2;
  border-left-color: #ef4444;
  color: #991b1b;
}

/* Forms & Buttons */
.form-label {
  display: block;
  font-size: 0.82rem;
  font-weight: 700;
  color: var(--text-main);
  margin-bottom: 6px;
}

.form-input, .form-select {
  width: 100%;
  padding: 8px 12px;
  font-family: inherit;
  font-size: 0.86rem;
  border: 1px solid var(--border-subtle);
  border-radius: var(--radius-sm);
  background: #ffffff;
  color: var(--text-main);
  transition: all 0.15s ease;
}

.form-input:focus, .form-select:focus {
  outline: none;
  border-color: var(--brand-primary);
  box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.12);
}

.btn-primary {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  gap: 8px;
  padding: 8px 16px;
  background: var(--brand-primary);
  color: #ffffff;
  border: none;
  border-radius: var(--radius-sm);
  font-family: inherit;
  font-size: 0.84rem;
  font-weight: 600;
  cursor: pointer;
  transition: all 0.15s ease;
}

.btn-primary:hover {
  background: var(--brand-primary-hover);
}

.btn-outline {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  gap: 8px;
  padding: 8px 14px;
  background: #ffffff;
  color: var(--text-main);
  border: 1px solid var(--border-subtle);
  border-radius: var(--radius-sm);
  font-family: inherit;
  font-size: 0.84rem;
  font-weight: 600;
  cursor: pointer;
  transition: all 0.15s ease;
}

.btn-outline:hover {
  background: var(--bg-hover);
  border-color: #cbd5e1;
}

/* Clean Flow Diagrams */
.flow-diagram {
  display: flex;
  align-items: stretch;
  gap: 12px;
  padding: 16px;
  background: #f8fafc;
  border: 1px solid var(--border-subtle);
  border-radius: var(--radius-sm);
  overflow-x: auto;
}

.flow-step {
  flex: 1;
  min-width: 150px;
  background: #ffffff;
  border: 1px solid var(--border-subtle);
  border-radius: var(--radius-sm);
  padding: 14px;
  text-align: center;
  display: flex;
  flex-direction: column;
  justify-content: center;
  box-shadow: var(--shadow-xs);
}

.flow-arrow {
  display: flex;
  align-items: center;
  color: #94a3b8;
  font-weight: bold;
  font-size: 1.1rem;
}

/* Clean Output Box */
.output-card {
  background: #f8fafc;
  border: 1px solid var(--border-subtle);
  border-radius: var(--radius-sm);
  padding: 16px;
  font-family: var(--font-mono);
  font-size: 0.82rem;
  line-height: 1.6;
  color: #334155;
  white-space: pre-wrap;
  margin-top: 14px;
}

/* KPI Cards */
.kpi-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
  gap: 14px;
  margin-bottom: 20px;
}

.kpi-box {
  background: #ffffff;
  border: 1px solid var(--border-subtle);
  border-radius: var(--radius-sm);
  padding: 16px;
  box-shadow: var(--shadow-xs);
}

.kpi-box .label {
  font-size: 0.74rem;
  color: var(--text-muted);
  text-transform: uppercase;
  font-weight: 700;
}

.kpi-box .val {
  font-size: 1.35rem;
  font-weight: 800;
  color: var(--text-main);
  margin-top: 2px;
}

.kpi-box .desc {
  font-size: 0.74rem;
  color: var(--text-light);
  margin-top: 2px;
}

/* Alignment utilities */
.text-right { text-align: right; }
.text-center { text-align: center; }
.font-mono { font-family: var(--font-mono); }

/* Footer */
.site-footer {
  background: #ffffff;
  border-top: 1px solid var(--border-subtle);
  padding: 20px 24px;
  margin-top: auto;
  font-size: 0.8rem;
  color: var(--text-muted);
}

.footer-content {
  max-width: 1320px;
  margin: 0 auto;
  display: flex;
  justify-content: space-between;
  align-items: center;
  flex-wrap: wrap;
  gap: 12px;
}

/* Responsive adjustments */
@media (max-width: 860px) {
  .header-container {
    flex-direction: column;
    align-items: flex-start;
  }
  .nav-pills {
    overflow-x: auto;
    width: 100%;
  }
  .welcome-hero::after {
    display: none;
  }
}

/* Print styling */
@media print {
  .site-header, .subtabs-bar, .btn-print, .btn-primary, .btn-outline {
    display: none !important;
  }
  .tab-pane, .subtab-content {
    display: block !important;
    page-break-after: auto;
  }
  body {
    background: #ffffff;
  }
  .clean-card {
    box-shadow: none !important;
    border: 1px solid #ccc !important;
    margin-bottom: 15px;
  }
}


/* ==========================================================================
   Modals, Demo Accounts, and Database Monitor Styling
   ========================================================================== */
.btn-user-badge {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  background: #ffffff;
  border: 1px solid var(--border-subtle);
  color: var(--text-main);
  padding: 6px 14px;
  border-radius: var(--radius-full);
  font-size: 0.82rem;
  font-weight: 600;
  cursor: pointer;
  transition: all 0.15s ease;
  box-shadow: var(--shadow-xs);
}
.btn-user-badge:hover {
  background: var(--bg-hover);
  border-color: #cbd5e1;
  box-shadow: var(--shadow-sm);
}

.erp-modal-overlay {
  display: none;
  position: fixed;
  top: 0; left: 0; right: 0; bottom: 0;
  background: rgba(15, 23, 42, 0.65);
  backdrop-filter: blur(4px);
  z-index: 1000;
  align-items: center;
  justify-content: center;
  padding: 20px;
}
.erp-modal-overlay.active {
  display: flex;
}
.erp-modal-box {
  background: #ffffff;
  border-radius: var(--radius-md);
  max-width: 680px;
  width: 100%;
  max-height: 90vh;
  overflow-y: auto;
  box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
  border: 1px solid var(--border-subtle);
  animation: gentleFadeIn 0.2s ease-out;
}
.erp-modal-header {
  padding: 16px 20px;
  border-bottom: 1px solid var(--border-subtle);
  display: flex;
  align-items: center;
  justify-content: space-between;
  background: #f8fafc;
}
.erp-modal-header h3 {
  font-size: 1.05rem;
  color: var(--text-main);
  margin: 0;
}
.erp-modal-close {
  background: none;
  border: none;
  font-size: 1.4rem;
  line-height: 1;
  color: var(--text-muted);
  cursor: pointer;
  padding: 4px;
}
.erp-modal-close:hover {
  color: var(--text-main);
}
.erp-modal-body {
  padding: 20px;
}
.demo-account-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
  gap: 10px;
  margin-top: 12px;
}
.demo-account-card {
  border: 1px solid var(--border-subtle);
  border-radius: var(--radius-sm);
  padding: 10px 12px;
  background: #ffffff;
  display: flex;
  align-items: center;
  justify-content: space-between;
  cursor: pointer;
  transition: all 0.15s ease;
}
.demo-account-card:hover {
  border-color: var(--brand-primary);
  background: var(--brand-primary-light);
  transform: translateY(-1px);
}
.demo-account-card.active {
  border-color: var(--brand-primary);
  background: var(--brand-primary-light);
  outline: 2px solid var(--brand-primary);
}
.demo-account-info {
  display: flex;
  align-items: center;
  gap: 10px;
}
.demo-account-avatar {
  font-size: 1.4rem;
  width: 36px;
  height: 36px;
  display: flex;
  align-items: center;
  justify-content: center;
  background: #f1f5f9;
  border-radius: 50%;
}
.demo-account-card strong {
  display: block;
  font-size: 0.86rem;
  color: var(--text-main);
}
.demo-account-card small {
  display: block;
  font-size: 0.74rem;
}


  /* ---- Perbaikan tampilan header & kartu modul ---- */
  .header-container { display:flex; flex-wrap:wrap; align-items:center; justify-content:space-between; gap:10px 16px; padding-top:10px; padding-bottom:10px; }
  .brand-section { flex:0 0 auto; white-space:nowrap; }
  .brand-meta h1 { font-size:1.05rem; white-space:nowrap; }
  .brand-meta p { font-size:0.7rem; line-height:1.2; white-space:nowrap; }
  .nav-pills { flex:1 1 auto; min-width:0; overflow-x:auto; scrollbar-width:none; }
  .nav-pills::-webkit-scrollbar { display:none; }
  .nav-pill-btn { white-space:nowrap; }
  .header-right { flex:0 0 auto; display:flex; align-items:center; gap:8px; flex-wrap:nowrap; }
  #db-status-badge, .btn-print, .btn-user-badge { white-space:nowrap; }
  .btn-user-badge strong { max-width:150px; overflow:hidden; text-overflow:ellipsis; }
  .btn-user-badge small { display:none; }
  @media (max-width:1599px) { .nav-pills { order:3; flex:1 1 100%; } }
  @media (max-width:700px) { .brand-meta p { display:none; } .header-right { width:100%; flex-wrap:wrap; justify-content:space-between; } .btn-user-badge { max-width:100%; } .btn-user-badge strong { max-width:110px; } .btn-print { display:none; } }
  .cards-container { grid-template-columns:repeat(auto-fit, minmax(220px, 1fr)); }
  @media (min-width:1200px) { .cards-container { grid-template-columns:repeat(5, 1fr); } }

  /* ---- Menu profil kanan atas ---- */
  .profile-menu { position:relative; }
  .btn-user-badge .pm-avatar { font-size:1.05rem; line-height:1; }
  .btn-user-badge .pm-caret { font-size:0.7rem; transition:transform .15s ease; }
  .btn-user-badge[aria-expanded="true"] .pm-caret { transform:rotate(180deg); }
  .btn-user-badge small { display:inline; color:var(--text-muted); font-weight:500; }
  .profile-dropdown { position:absolute; right:0; top:calc(100% + 8px); width:310px; max-width:calc(100vw - 24px); background:#fff; border:1px solid var(--border-subtle); border-radius:14px; box-shadow:0 18px 40px rgba(15,23,42,.16); z-index:200; overflow:hidden; }
  .profile-dropdown[hidden] { display:none; }
  .pd-head { display:flex; gap:12px; align-items:center; padding:16px; background:linear-gradient(135deg,#eff6ff,#eef2ff); border-bottom:1px solid var(--border-subtle); }
  .pd-avatar { font-size:1.7rem; width:50px; height:50px; flex:0 0 50px; display:flex; align-items:center; justify-content:center; background:#fff; border-radius:50%; box-shadow:0 1px 4px rgba(0,0,0,.1); }
  .pd-meta { display:flex; flex-direction:column; min-width:0; gap:1px; }
  .pd-meta strong { font-size:.92rem; color:var(--text-main); }
  .pd-meta span { font-size:.76rem; color:var(--text-muted); }
  .pd-meta #pd-role { color:var(--brand-primary); font-weight:600; }
  .pd-meta code { font-size:.72rem; color:var(--text-muted); }
  .pd-list { padding:6px; }
  .pd-item { display:flex; gap:10px; align-items:center; width:100%; text-align:left; background:none; border:0; padding:9px 10px; border-radius:10px; cursor:pointer; font:inherit; color:var(--text-main); }
  .pd-item:hover, .pd-item:focus-visible { background:var(--brand-primary-light); outline:none; }
  .pd-item b { display:block; font-size:.84rem; font-weight:600; }
  .pd-item small { display:block; font-size:.72rem; color:var(--text-muted); }
  .pd-ico { font-size:1.1rem; width:28px; text-align:center; }
  .pd-logout { display:block; width:100%; padding:12px; border:0; border-top:1px solid var(--border-subtle); background:#fef2f2; color:#b91c1c; font:inherit; font-weight:700; font-size:.85rem; cursor:pointer; }
  .pd-logout:hover { background:#fee2e2; }
  @media (max-width:700px) { .btn-user-badge small { display:none; } .profile-menu { margin-left:auto; } }

  /* ---- Kartu profil cetak ---- */
  #print-profile-sheet { display:none; }
  @media print {
    @page { size:A4; margin:16mm; }
    .profile-menu, #db-status-badge { display:none !important; }
    body.print-profile .main-wrapper, body.print-profile .site-footer, body.print-profile .site-header { display:none !important; }
    body.print-profile #print-profile-sheet { display:block !important; }
    #print-profile-sheet { font-family:'Plus Jakarta Sans',Arial,sans-serif; color:#0f172a; }
    .pps-head { border-bottom:3px solid #3b82f6; padding-bottom:10px; margin-bottom:22px; }
    .pps-logo { font-size:20pt; font-weight:800; color:#1d4ed8; }
    .pps-sub { font-size:10pt; color:#64748b; }
    #print-profile-sheet h2 { font-size:16pt; margin-bottom:14px; }
    .pps-card { border:1px solid #cbd5e1; border-radius:12px; padding:20px; display:flex; gap:20px; align-items:flex-start; }
    .pps-avatar { font-size:40pt; width:80px; height:80px; border-radius:50%; background:#eff6ff; display:flex; align-items:center; justify-content:center; flex:0 0 80px; }
    .pps-card table { border-collapse:collapse; width:100%; font-size:11pt; }
    .pps-card th { text-align:left; width:36%; padding:7px 0; color:#64748b; font-weight:600; vertical-align:top; }
    .pps-card td { padding:7px 0; font-weight:600; }
    .pps-foot { margin-top:24px; font-size:9pt; color:#94a3b8; }
  }
  </style>
  <script src="js/auth.js"></script>
</head>
<body>

  <!-- Clean Top Navigation Bar -->
  <header class="site-header">
    <div class="header-container">
      <div class="brand-section" onclick="navigateToTab('beranda')">
        <div class="brand-icon-box">
          <!-- Clean Academic Shield Icon -->
          <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M12 2L3 7v6c0 5.5 3.8 10.7 9 12 5.2-1.3 9-6.5 9-12V7l-9-5z"/>
            <path d="M12 8v8"/>
            <path d="M8 12h8"/>
          </svg>
        </div>
        <div class="brand-meta">
          <h1>META ERP Portal</h1>
          <p>Politeknik META Industri • TRPL PL/4008</p>
        </div>
      </div>

      <!-- Main Practicum Navigation -->
      <nav class="nav-pills" aria-label="Navigasi Praktikum">
        <button class="nav-pill-btn active" data-tab="beranda">
          🏠 Beranda
        </button>
        <button class="nav-pill-btn" data-tab="p1">
          <span class="pill-num">1</span> Evolusi ERP
        </button>
        <button class="nav-pill-btn" data-tab="p2">
          <span class="pill-num">2</span> Arsitektur Teknis
        </button>
        <button class="nav-pill-btn" data-tab="p3">
          <span class="pill-num">3</span> Alur Persetujuan
        </button>
        <button class="nav-pill-btn" data-tab="p4">
          <span class="pill-num">4</span> Modul Keuangan
        </button>
        <button class="nav-pill-btn" data-tab="p5">
          <span class="pill-num">5</span> SCM & MRP
        </button>
      </nav>

      <div class="header-right">
        <!-- Status Database Badge -->
        <span id="db-status-badge" class="tag tag-amber" style="cursor:pointer;" title="Klik untuk cek status database & petunjuk integrasi">
          🟡 Mengecek Database...
        </span>

        <!-- Menu Profil Akun (kanan atas) -->
        <div class="profile-menu" id="profile-menu">
          <button id="btn-user-profile" class="btn-user-badge" aria-haspopup="true" aria-expanded="false" aria-controls="profile-dropdown" title="Profil akun">
            <span id="user-badge-avatar" class="pm-avatar">⭐</span>
            <strong id="user-badge-name">Yazid</strong>
            <small id="user-badge-role">(Mahasiswa TRPL)</small>
            <span class="pm-caret" aria-hidden="true">▾</span>
          </button>
          <div id="profile-dropdown" class="profile-dropdown" role="menu" hidden>
            <div class="pd-head">
              <div class="pd-avatar" id="pd-avatar">⭐</div>
              <div class="pd-meta">
                <strong id="pd-name">-</strong>
                <span id="pd-role">-</span>
                <span id="pd-dept">-</span>
                <code id="pd-user">@-</code>
              </div>
            </div>
            <div class="pd-list">
              <button type="button" class="pd-item" id="btn-print-pdf" role="menuitem">
                <span class="pd-ico">🖨️</span>
                <span><b>Cetak / Simpan PDF</b><small>Cetak halaman yang sedang dibuka</small></span>
              </button>
              <button type="button" class="pd-item" id="btn-print-profile" role="menuitem">
                <span class="pd-ico">🪪</span>
                <span><b>Cetak Profil Akun (PDF)</b><small>Kartu profil pengguna satu halaman</small></span>
              </button>
              <button type="button" class="pd-item" id="btn-db-status" role="menuitem">
                <span class="pd-ico">🗄️</span>
                <span><b>Status Database</b><small>Cek koneksi &amp; sinkronisasi</small></span>
              </button>
            </div>
            <button type="button" id="btn-logout" class="pd-logout" role="menuitem">⎋ Keluar (Logout)</button>
          </div>
        </div>
      </div>
    </div>
  </header>

  <!-- Main View Container -->
  <main class="main-wrapper">

    <!-- ====================================================================
         VIEW: BERANDA (HOME / PORTAL UTAMA)
         ==================================================================== -->
    <section id="beranda" class="tab-pane active">
      <!-- Welcome Hero Banner -->
      <div class="welcome-hero">
        <div class="hero-pill-badge">
          🎓 UTS Semester Ganjil 2026/2027 • Dosen: Adie Kusna Wibowo
        </div>
        <h2>Portal Praktikum Sistem Enterprise Resource Planning</h2>
        <p class="lead">
          Selamat datang di platform praktikum ERP terpadu. Seluruh materi praktikum 1 sampai 5 telah disusun secara sistematis, terstruktur per tahapan, dan dilengkapi data dummy interaktif untuk memudahkan pemahaman konsep serta simulasi operasional bisnis.
        </p>

        <div class="hero-stats-row">
          <div class="stat-item">
            <span class="stat-label">Program Studi</span>
            <span class="stat-val">TRPL (3 SKS)</span>
          </div>
          <div class="stat-item">
            <span class="stat-label">Institusi</span>
            <span class="stat-val">Politeknik META Industri</span>
          </div>
          <div class="stat-item">
            <span class="stat-label">Kawasan</span>
            <span class="stat-val">Cikarang Technopark</span>
          </div>
          <div class="stat-item">
            <span class="stat-label">Prinsip Ujian</span>
            <span class="stat-val">Proses, Simulasi & Analisis</span>
          </div>
        </div>
      </div>

      <!-- Section Title -->
      <div class="home-section-title">
        <h3>Pilih Modul Praktikum</h3>
        <span class="tag tag-blue">5 Modul Lengkap</span>
      </div>

      <!-- 5 Practicum Cards Grid -->
      <div class="cards-container">
        
        <!-- Card 1 -->
        <div class="course-card" style="--card-color: #2563eb; --card-color-bg: #eff6ff;" onclick="navigateToTab('p1')">
          <div>
            <div class="card-top">
              <div class="card-icon">01</div>
              <span class="card-num-text">Modul 1</span>
            </div>
            <div class="card-content">
              <h4>Evolusi & Integrasi ERP</h4>
              <p>Analisis silo data 4 departemen pabrik otomotif, diagram proses As-Is vs To-Be, standarisasi 5 data master bersama, dan simulasi pesanan penjualan.</p>
            </div>
          </div>
          <div class="card-action">
            <span>Buka Modul 1</span>
            <span>➔</span>
          </div>
        </div>

        <!-- Card 2 -->
        <div class="course-card" style="--card-color: #0284c7; --card-color-bg: #f0f9ff;" onclick="navigateToTab('p2')">
          <div>
            <div class="card-top">
              <div class="card-icon">02</div>
              <span class="card-num-text">Modul 2</span>
            </div>
            <div class="card-content">
              <h4>Arsitektur Teknis ERP</h4>
              <p>Desain arsitektur 3-Tier Enterprise untuk 100 pengguna, matriks hak akses keamanan (RBAC), strategi backup 3-2-1, dan simulator 5 kondisi gangguan server.</p>
            </div>
          </div>
          <div class="card-action">
            <span>Buka Modul 2</span>
            <span>➔</span>
          </div>
        </div>

        <!-- Card 3 -->
        <div class="course-card" style="--card-color: #059669; --card-color-bg: #ecfdf5;" onclick="navigateToTab('p3')">
          <div>
            <div class="card-top">
              <div class="card-icon">03</div>
              <span class="card-num-text">Modul 3</span>
            </div>
            <div class="card-content">
              <h4>Alur Persetujuan & Bisnis</h4>
              <p>Pemetaan pengadaan bahan praktik Lab Manufaktur META Industri, aturan bisnis berjenjang, tabel RACI, dan simulasi kenaikan nilai pembelian (re-approval).</p>
            </div>
          </div>
          <div class="card-action">
            <span>Buka Modul 3</span>
            <span>➔</span>
          </div>
        </div>

        <!-- Card 4 -->
        <div class="course-card" style="--card-color: #d97706; --card-color-bg: #fffbeb;" onclick="navigateToTab('p4')">
          <div>
            <div class="card-top">
              <div class="card-icon">04</div>
              <span class="card-num-text">Modul 4</span>
            </div>
            <div class="card-content">
              <h4>Modul Keuangan (FI)</h4>
              <p>Simulasi PT Mekar Komponen dengan kas Rp 30 Juta, jurnal otomatis 5 transaksi, buku besar, neraca saldo seimbang, dan koreksi dobel input berjejak audit.</p>
            </div>
          </div>
          <div class="card-action">
            <span>Buka Modul 4</span>
            <span>➔</span>
          </div>
        </div>

        <!-- Card 5 -->
        <div class="course-card" style="--card-color: #dc2626; --card-color-bg: #fef2f2;" onclick="navigateToTab('p5')">
          <div>
            <div class="card-top">
              <div class="card-icon">05</div>
              <span class="card-num-text">Modul 5</span>
            </div>
            <div class="card-content">
              <h4>Modul SCM & MRP</h4>
              <p>Struktur BOM 300 unit produk, kalkulasi kebutuhan material bruto/bersih, identifikasi bottleneck lead time 7 hari vs target 6 hari, dan mitigasi keterlambatan vendor.</p>
            </div>
          </div>
          <div class="card-action">
            <span>Buka Modul 5</span>
            <span>➔</span>
          </div>
        </div>

      </div>

      <!-- Clean Rubric Summary -->
      <div class="clean-card">
        <div class="card-title-bar">
          <h3>📋 Standar Rubrik Penilaian Ujian (Bobot Praktikum 50%)</h3>
          <span class="tag tag-gray">Pedoman Dosen</span>
        </div>
        <p style="font-size:0.86rem; color:var(--text-muted); margin-bottom:14px;">
          Penilaian didasarkan pada ketepatan proses, hasil konfigurasi, kemampuan menguji kesalahan, dan alasan pengambilan keputusan, bukan hanya tampilan akhir:
        </p>
        <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap:12px;">
          <div style="background:#f8fafc; border:1px solid var(--border-subtle); border-radius:var(--radius-sm); padding:12px;">
            <strong style="font-size:0.85rem; color:var(--brand-primary-dark);">Konfigurasi & Desain: 25%</strong>
            <p style="font-size:0.78rem; color:var(--text-muted); margin-top:2px;">Ketepatan struktur akun, BOM, dan arsitektur.</p>
          </div>
          <div style="background:#f8fafc; border:1px solid var(--border-subtle); border-radius:var(--radius-sm); padding:12px;">
            <strong style="font-size:0.85rem; color:var(--brand-primary-dark);">Hasil Perhitungan: 25%</strong>
            <p style="font-size:0.78rem; color:var(--text-muted); margin-top:2px;">Akurasi saldo keuangan dan kebutuhan MRP.</p>
          </div>
          <div style="background:#f8fafc; border:1px solid var(--border-subtle); border-radius:var(--radius-sm); padding:12px;">
            <strong style="font-size:0.85rem; color:var(--brand-primary-dark);">Pengujian Skenario: 20%</strong>
            <p style="font-size:0.78rem; color:var(--text-muted); margin-top:2px;">Uji perubahan kondisi dan respon sistem.</p>
          </div>
          <div style="background:#f8fafc; border:1px solid var(--border-subtle); border-radius:var(--radius-sm); padding:12px;">
            <strong style="font-size:0.85rem; color:var(--brand-primary-dark);">Analisis Kesalahan: 15%</strong>
            <p style="font-size:0.78rem; color:var(--text-muted); margin-top:2px;">Deteksi kesalahan input dan audit trail.</p>
          </div>
          <div style="background:#f8fafc; border:1px solid var(--border-subtle); border-radius:var(--radius-sm); padding:12px;">
            <strong style="font-size:0.85rem; color:var(--brand-primary-dark);">Pertanggungjawaban: 15%</strong>
            <p style="font-size:0.78rem; color:var(--text-muted); margin-top:2px;">Alasan logis pengambilan keputusan bisnis.</p>
          </div>
        </div>
      </div>
    </section>


    <!-- ====================================================================
         VIEW: PRAKTIKUM 1 (EVOLUSI DAN INTEGRASI ERP)
         ==================================================================== -->
    <section id="p1" class="tab-pane">
      <!-- Header Banner -->
      <div class="module-banner" style="--module-accent: #2563eb;">
        <div class="module-info">
          <div class="module-badge-num">1</div>
          <div>
            <h2>Praktikum 1: Menganalisis Evolusi dan Integrasi ERP</h2>
            <p>Studi Kasus: Perusahaan Manufaktur Komponen Otomotif (4 Departemen Terpisah)</p>
          </div>
        </div>
        <button class="btn-outline" onclick="navigateToTab('beranda')">← Kembali ke Beranda</button>
      </div>

      <!-- Sub-Tabs Navigation for Clean Step-by-Step Viewing -->
      <div class="subtabs-bar" data-module="p1">
        <button class="subtab-btn active" data-subtab="p1-sub-silo">1. Analisis Silo Data</button>
        <button class="subtab-btn" data-subtab="p1-sub-diagram">2. Diagram As-Is vs To-Be</button>
        <button class="subtab-btn" data-subtab="p1-sub-master">3. Master Data Bersama</button>
        <button class="subtab-btn" data-subtab="p1-sub-simulasi">4. Simulasi Transaksi SO</button>
        <button class="subtab-btn" data-subtab="p1-sub-tantangan">5. Tantangan Kondisi Dosen</button>
      </div>

      <!-- Subtab 1: Silo Data -->
      <div id="p1-sub-silo" class="subtab-content active">
        <div class="clean-card">
          <div class="card-title-bar"><h3>Hubungan Data yang Belum Terintegrasi</h3><span class="tag tag-red">Tugas 1</span></div>
          <div style="overflow-x:auto;"><table class="clean-table"><thead><tr><th>Dari</th><th>Ke</th><th>Data yang harus mengalir</th><th>Kondisi saat ini</th></tr></thead><tbody>
            <tr><td>Penjualan (Spreadsheet)</td><td>Gudang</td><td>Pesanan &amp; kebutuhan stok</td><td>Pesanan terlambat diperbarui, stok tidak teralokasi</td></tr>
            <tr><td>Penjualan</td><td>Produksi (Formulir manual)</td><td>Jumlah &amp; tanggal pesanan</td><td>Jadwal produksi sering berubah</td></tr>
            <tr><td>Gudang (Aplikasi stok)</td><td>Pembelian</td><td>Stok &amp; penerimaan barang</td><td>Stok berbeda dengan catatan pembelian</td></tr>
            <tr><td>Produksi</td><td>Gudang</td><td>Pemakaian bahan baku &amp; hasil jadi</td><td>Dicatat manual, selisih stok</td></tr>
            <tr><td>Penjualan, Gudang, Produksi</td><td>Keuangan (Aplikasi akuntansi)</td><td>Faktur, mutasi stok, biaya</td><td>Transaksi harus dimasukkan ulang</td></tr>
          </tbody></table></div>
        </div>
        <div class="clean-card">
          <div class="card-title-bar">
            <h3>Hubungan Data yang Belum Terintegrasi (Data Silo)</h3>
            <span class="tag tag-amber">Kondisi Awal</span>
          </div>
          <p style="font-size:0.86rem; color:var(--text-muted); margin-bottom:14px;">
            Identifikasi masalah komunikasi data pada 4 departemen perusahaan komponen otomotif:
          </p>
          <div class="table-wrap">
            <table class="clean-table">
              <thead>
                <tr>
                  <th>Departemen</th>
                  <th>Sistem Saat Ini</th>
                  <th>Masalah yang Ditemukan</th>
                  <th>Dampak Negatif</th>
                  <th>Solusi Terintegrasi ERP</th>
                </tr>
              </thead>
              <tbody id="p1-silo-table-body">
                <!-- Rendered via js/app.js -->
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <!-- Subtab 2: Diagram As-Is vs To-Be -->
      <div id="p1-sub-diagram" class="subtab-content">
        <div class="clean-card">
          <div class="card-title-bar">
            <h3>Diagram Arsitektur Proses: Sebelum vs Sesudah ERP</h3>
            <span class="tag tag-blue">Perbandingan Alur</span>
          </div>

          <div style="margin-bottom:20px;">
            <strong style="font-size:0.9rem; color:#b91c1c; display:block; margin-bottom:8px;">
              A. Sebelum ERP (As-Is): Terpisah, Manual & Rawan Keterlambatan
            </strong>
            <div class="flow-diagram">
              <div class="flow-step" style="border-color:#fca5a5; background:#fffafa;">
                <strong>Penjualan (Sales)</strong>
                <span style="font-size:0.75rem; color:#64748b;">Spreadsheet Excel</span>
                <span class="tag tag-red" style="margin-top:6px;">Rawan Janji Palsu</span>
              </div>
              <div class="flow-arrow">➔</div>
              <div class="flow-step" style="border-color:#fca5a5; background:#fffafa;">
                <strong>Produksi (Shopfloor)</strong>
                <span style="font-size:0.75rem; color:#64748b;">Catatan Kertas Manual</span>
                <span class="tag tag-red" style="margin-top:6px;">Jadwal Berubah-ubah</span>
              </div>
              <div class="flow-arrow">➔</div>
              <div class="flow-step" style="border-color:#fca5a5; background:#fffafa;">
                <strong>Gudang (Warehouse)</strong>
                <span style="font-size:0.75rem; color:#64748b;">Aplikasi Stok Lokal</span>
                <span class="tag tag-red" style="margin-top:6px;">Selisih Stok Fisik</span>
              </div>
              <div class="flow-arrow">➔</div>
              <div class="flow-step" style="border-color:#fca5a5; background:#fffafa;">
                <strong>Keuangan (Finance)</strong>
                <span style="font-size:0.75rem; color:#64748b;">Software Akuntansi Standalone</span>
                <span class="tag tag-red" style="margin-top:6px;">Input Ulang Manual</span>
              </div>
            </div>
          </div>

          <div>
            <strong style="font-size:0.9rem; color:#047857; display:block; margin-bottom:8px;">
              B. Sesudah ERP (To-Be): Terpusat pada Single Source of Truth
            </strong>
            <div class="flow-diagram" style="background:#f0fdf4; border-color:#bbf7d0;">
              <div class="flow-step" style="border-color:#86efac;">
                <strong>Modul Sales (SD)</strong>
                <span style="font-size:0.75rem; color:#64748b;">Cek Kuota & Limit Kredit</span>
                <span class="tag tag-green" style="margin-top:6px;">Real-time</span>
              </div>
              <div class="flow-arrow" style="color:#059669;">⇄</div>
              <div class="flow-step" style="background:#ffffff; border:2px solid #3b82f6;">
                <strong style="color:#1d4ed8;">DATABASE ERP TERPUSAT</strong>
                <span style="font-size:0.75rem; color:#64748b;">Single Source of Truth</span>
                <span class="tag tag-blue" style="margin-top:6px;">Master Data Bersama</span>
              </div>
              <div class="flow-arrow" style="color:#059669;">⇄</div>
              <div class="flow-step" style="border-color:#86efac;">
                <strong>Gudang & Produksi</strong>
                <span style="font-size:0.75rem; color:#64748b;">Auto Work Order & MRP</span>
                <span class="tag tag-green" style="margin-top:6px;">Alokasi Instan</span>
              </div>
              <div class="flow-arrow" style="color:#059669;">⇄</div>
              <div class="flow-step" style="border-color:#86efac;">
                <strong>Keuangan (FI/CO)</strong>
                <span style="font-size:0.75rem; color:#64748b;">Auto Journal & Laporan</span>
                <span class="tag tag-green" style="margin-top:6px;">Tanpa Ketik Ulang</span>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Subtab 3: Master Data -->
      <div id="p1-sub-master" class="subtab-content">
        <div class="clean-card">
          <div class="card-title-bar">
            <h3>Daftar Data Master yang Perlu Digunakan Bersama</h3>
            <span class="tag tag-green">Integritas Data</span>
          </div>
          <p style="font-size:0.86rem; color:var(--text-muted); margin-bottom:14px;">
            5 data master yang menjadi pondasi sinkronisasi lintas bagian agar tidak terjadi input ganda:
          </p>
          <div class="table-wrap">
            <table class="clean-table">
              <thead>
                <tr>
                  <th>Kode</th>
                  <th>Nama Master Data</th>
                  <th>Pemilik Utama</th>
                  <th>Pengguna Data</th>
                  <th>Atribut Utama</th>
                  <th>Contoh Data Dummy</th>
                </tr>
              </thead>
              <tbody id="p1-master-table-body">
                <!-- Rendered via js/app.js -->
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <!-- Subtab 4: Simulasi Transaksi -->
      <div id="p1-sub-simulasi" class="subtab-content">
        <div class="clean-card">
          <div class="card-title-bar">
            <h3>Simulasi Transaksi Pesanan Pelanggan (Sales Order Flow)</h3>
            <span class="tag tag-blue">Uji Interaktif</span>
          </div>
          <p style="font-size:0.86rem; color:var(--text-muted); margin-bottom:14px;">
            Lihat bagaimana sebuah pesanan dari pelanggan langsung berdampak serentak ke stok gudang, jadwal produksi, dan keuangan:
          </p>

          <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap:14px; margin-bottom:16px;">
            <div>
              <label class="form-label" for="p1-sim-cust">Nama Pelanggan:</label>
              <select id="p1-sim-cust" class="form-select">
                <option value="PT Astra Honda Motor (CUST-001)">PT Astra Honda Motor (CUST-001)</option>
                <option value="PT Toyota Motor Mfg (CUST-002)">PT Toyota Motor Mfg (CUST-002)</option>
                <option value="PT Yamaha Indonesia (CUST-003)">PT Yamaha Indonesia (CUST-003)</option>
              </select>
            </div>
            <div>
              <label class="form-label" for="p1-sim-item">Komponen Produk:</label>
              <select id="p1-sim-item" class="form-select">
                <option value="Brake Caliper Assy Type-C (MAT-FG-001)">Brake Caliper Assy Type-C (MAT-FG-001)</option>
                <option value="Piston Master Cylinder (MAT-FG-002)">Piston Master Cylinder (MAT-FG-002)</option>
              </select>
            </div>
            <div>
              <label class="form-label" for="p1-sim-qty">Jumlah Unit:</label>
              <input type="number" id="p1-sim-qty" class="form-input" value="50" min="1" max="500">
            </div>
          </div>

          <button id="p1-run-order-sim" class="btn-primary">
            🚀 Jalankan Transaksi ERP
          </button>

          <div id="p1-sim-terminal" class="output-card">
[KLIK TOMBOL DI ATAS UNTUK MELIHAT JEJAK DATA LINTAS MODUL]
          </div>
        </div>
      </div>

      <!-- Subtab 5: Tantangan Kondisi Dosen -->
      <div id="p1-sub-tantangan" class="subtab-content">
        <div class="clean-card">
          <div class="card-title-bar">
            <h3>Tantangan Perubahan Kondisi Individual (Ujian Dosen)</h3>
            <span class="tag tag-amber">Skenario Dinamis</span>
          </div>
          <p style="font-size:0.86rem; color:var(--text-muted); margin-bottom:12px;">
            Pilih salah satu kondisi pengujian di bawah ini untuk melihat bagian proses yang terdampak dan solusi sistem ERP:
          </p>
          <div style="display:flex; flex-wrap:wrap; gap:8px; margin-bottom:14px;">
            <button class="btn-outline p1-challenge-btn active" data-challenge="c1">1. Stok Bahan Baku Kurang</button>
            <button class="btn-outline p1-challenge-btn" data-challenge="c2">2. Pelanggan Ubah Pesanan</button>
            <button class="btn-outline p1-challenge-btn" data-challenge="c3">3. Pembayaran Belum Diterima</button>
            <button class="btn-outline p1-challenge-btn" data-challenge="c4">4. Produksi Mesin Terlambat</button>
          </div>
          <div id="p1-challenge-output">
            <!-- Rendered via js/app.js -->
          </div>
        </div>
      </div>
    </section>


    <!-- ====================================================================
         VIEW: PRAKTIKUM 2 (ARSITEKTUR TEKNIS ERP)
         ==================================================================== -->
    <section id="p2" class="tab-pane">
      <!-- Header Banner -->
      <div class="module-banner" style="--module-accent: #0284c7;">
        <div class="module-info">
          <div class="module-badge-num">2</div>
          <div>
            <h2>Praktikum 2: Merancang dan Menguji Arsitektur Teknis ERP</h2>
            <p>Target: 100 Pengguna (5 Bagian) • High-Availability • Keamanan RBAC • Pengujian Gangguan</p>
          </div>
        </div>
        <button class="btn-outline" onclick="navigateToTab('beranda')">← Kembali ke Beranda</button>
      </div>

      <!-- Sub-Tabs Navigation -->
      <div class="subtabs-bar" data-module="p2">
        <button class="subtab-btn active" data-subtab="p2-sub-arsitektur">1. Arsitektur 3-Tier</button>
        <button class="subtab-btn" data-subtab="p2-sub-rbac">2. Matriks Hak Akses (RBAC)</button>
        <button class="subtab-btn" data-subtab="p2-sub-backup">3. Strategi Backup & RPO/RTO</button>
        <button class="subtab-btn" data-subtab="p2-sub-flow">4. Aliran Data Pembelian</button>
        <button class="subtab-btn" data-subtab="p2-sub-gangguan">5. Uji Gangguan (Chaos Test)</button>
      </div>

      <!-- Subtab 1: Arsitektur 3-Tier -->
      <div id="p2-sub-arsitektur" class="subtab-content active">
        <div class="clean-card">
          <div class="card-title-bar">
            <h3>Rancangan Arsitektur Teknis ERP 3-Tier Enterprise</h3>
            <span class="tag tag-blue">100 Pengguna</span>
          </div>
          <p style="font-size:0.86rem; color:var(--text-muted); margin-bottom:16px;">
            Menghilangkan <em>Single Point of Failure (SPOF)</em> untuk melayani 100 pegawai di 5 bagian (Penjualan 20, Gudang 15, Produksi 30, Pembelian 15, Keuangan 20):
          </p>

          <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap:14px;">
            <div style="background:#f8fafc; border:1px solid #cbd5e1; border-radius:var(--radius-sm); padding:16px;">
              <span class="tag tag-blue" style="margin-bottom:8px;">Tier 1: Presentation Tier</span>
              <strong style="display:block; font-size:0.95rem; color:var(--text-main);">Klien & Perangkat</strong>
              <p style="font-size:0.8rem; color:var(--text-muted); margin-top:4px;">
                Browser HTTPS pada PC kantor (LAN Gigabit) & Laptop WFH melalui VPN WireGuard/IPSec terenkripsi.
              </p>
            </div>

            <div style="background:#f8fafc; border:1px solid #cbd5e1; border-radius:var(--radius-sm); padding:16px;">
              <span class="tag tag-blue" style="margin-bottom:8px;">Tier 2: Application Tier</span>
              <strong style="display:block; font-size:0.95rem; color:var(--text-main);">Load Balancer & Cluster</strong>
              <p style="font-size:0.8rem; color:var(--text-muted); margin-top:4px;">
                NGINX Reverse Proxy membagi beban secara seimbang ke 2 Instance App Server (Zero Downtime).
              </p>
            </div>

            <div style="background:#f8fafc; border:1px solid #cbd5e1; border-radius:var(--radius-sm); padding:16px;">
              <span class="tag tag-blue" style="margin-bottom:8px;">Tier 3: Database Tier</span>
              <strong style="display:block; font-size:0.95rem; color:var(--text-main);">Primary & Replica DB</strong>
              <p style="font-size:0.8rem; color:var(--text-muted); margin-top:4px;">
                PostgreSQL Primary untuk transaksi Read/Write dengan replikasi streaming ke Read-Replica.
              </p>
            </div>

            <div style="background:#f8fafc; border:1px solid #cbd5e1; border-radius:var(--radius-sm); padding:16px;">
              <span class="tag tag-blue" style="margin-bottom:8px;">Backup Tier</span>
              <strong style="display:block; font-size:0.95rem; color:var(--text-main);">Pencadangan Otomatis</strong>
              <p style="font-size:0.8rem; color:var(--text-muted); margin-top:4px;">
                Sistem pencadangan otomatis 3-2-1 harian + continuous WAL log 5 menit ke Object Storage Cloud.
              </p>
            </div>
          </div>
        </div>
      </div>

      <!-- Subtab 2: RBAC Matrix -->
      <div id="p2-sub-rbac" class="subtab-content">
        <div class="clean-card">
          <div class="card-title-bar">
            <h3>Matriks Hak Akses Pengguna (Role-Based Access Control)</h3>
            <span class="tag tag-green">Keamanan Akses</span>
          </div>
          <p style="font-size:0.86rem; color:var(--text-muted); margin-bottom:14px;">
            Setiap departemen hanya diberikan hak akses yang relevan dengan tugasnya (*Least Privilege Principle*):
          </p>
          <div class="table-wrap">
            <table class="clean-table">
              <thead>
                <tr>
                  <th>Peran / Jabatan</th>
                  <th>Penjualan</th>
                  <th>Gudang</th>
                  <th>Produksi</th>
                  <th>Pembelian</th>
                  <th>Keuangan</th>
                  <th>Catatan Otorisasi</th>
                </tr>
              </thead>
              <tbody id="p2-rbac-body">
                <!-- Rendered via js/app.js -->
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <!-- Subtab 3: Backup & Recovery -->
      <div id="p2-sub-backup" class="subtab-content">
        <div class="clean-card">
          <div class="card-title-bar">
            <h3>Strategi Pencadangan Database & Prosedur Pemulihan Data</h3>
            <span class="tag tag-amber">SOP Disaster Recovery</span>
          </div>

          <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap:16px;">
            <div style="background:#f8fafc; border:1px solid var(--border-subtle); border-radius:var(--radius-sm); padding:16px;">
              <strong style="font-size:0.9rem; color:var(--text-main); display:block; margin-bottom:6px;">
                🛡️ Kebijakan Pencadangan (3-2-1 Rule)
              </strong>
              <ul style="font-size:0.82rem; color:var(--text-muted); padding-left:18px; line-height:1.6;">
                <li><strong>3 Salinan:</strong> 1 Database aktif, 1 Backup di NAS lokal, 1 Backup di Cloud Storage.</li>
                <li><strong>2 Media Berbeda:</strong> Storage server NVMe lokal dan Object Storage S3 terisolasi.</li>
                <li><strong>1 Lokasi Terpisah (Offsite):</strong> Data center di luar area kawasan Lippo Cikarang.</li>
                <li><strong>Jadwal:</strong> Full snapshot setiap pukul 01:00 WIB + Continuous WAL log per 5 menit.</li>
              </ul>
            </div>

            <div style="background:#f8fafc; border:1px solid var(--border-subtle); border-radius:var(--radius-sm); padding:16px;">
              <strong style="font-size:0.9rem; color:var(--text-main); display:block; margin-bottom:6px;">
                ⏱️ Target RTO & RPO Pemulihan
              </strong>
              <ul style="font-size:0.82rem; color:var(--text-muted); padding-left:18px; line-height:1.6;">
                <li><strong>RTO (Recovery Time Objective):</strong> &lt; 30 Menit untuk memulihkan layanan operasional.</li>
                <li><strong>RPO (Recovery Point Objective):</strong> &lt; 5 Menit (toleransi data transaksi hilang maksimal 5 menit).</li>
                <li><strong>Prosedur:</strong> Isolasi node rusak ➔ Promosi Replica ke Master ➔ Arahkan DNS ➔ Replay log transaksi WAL terakhir.</li>
              </ul>
            </div>
          </div>
        </div>
      </div>

      <!-- Subtab 4: Flow Pembelian -->
      <div id="p2-sub-flow" class="subtab-content">
        <div class="clean-card">
          <div class="card-title-bar">
            <h3>Aliran Data Transaksi Pembelian (Procure-to-Pay)</h3>
            <span class="tag tag-blue">Siklus Dokumen</span>
          </div>
          <div class="flow-diagram">
            <div class="flow-step">
              <strong>1. Permintaan (PR)</strong>
              <span style="font-size:0.75rem; color:#64748b;">User Bagian Terkait</span>
            </div>
            <div class="flow-arrow">➔</div>
            <div class="flow-step">
              <strong>2. Pesanan (PO)</strong>
              <span style="font-size:0.75rem; color:#64748b;">Bagian Pembelian</span>
            </div>
            <div class="flow-arrow">➔</div>
            <div class="flow-step">
              <strong>3. Penerimaan (GRN)</strong>
              <span style="font-size:0.75rem; color:#64748b;">Petugas Gudang</span>
            </div>
            <div class="flow-arrow">➔</div>
            <div class="flow-step">
              <strong>4. Faktur Utang (AP)</strong>
              <span style="font-size:0.75rem; color:#64748b;">Bagian Keuangan</span>
            </div>
            <div class="flow-arrow">➔</div>
            <div class="flow-step">
              <strong>5. Pembayaran</strong>
              <span style="font-size:0.75rem; color:#64748b;">Buku Kas / Bank</span>
            </div>
          </div>
        </div>
      </div>

      <!-- Subtab 5: Uji Gangguan -->
      <div id="p2-sub-gangguan" class="subtab-content">
        <div class="clean-card">
          <div class="card-title-bar">
            <h3>Simulator Pengujian Gangguan Teknis (Chaos Test)</h3>
            <span class="tag tag-red">Pengujian Dosen</span>
          </div>
          <p style="font-size:0.86rem; color:var(--text-muted); margin-bottom:12px;">
            Pilih salah satu kondisi gangguan untuk melihat analisis dampak dan mekanisme pemulihan:
          </p>
          <div style="display:flex; flex-wrap:wrap; gap:8px; margin-bottom:14px;">
            <button class="btn-outline p2-disaster-btn active" data-disaster="ds1">1. Database Crash</button>
            <button class="btn-outline p2-disaster-btn" data-disaster="ds2">2. Server Aplikasi OOM</button>
            <button class="btn-outline p2-disaster-btn" data-disaster="ds3">3. Internet Terputus</button>
            <button class="btn-outline p2-disaster-btn" data-disaster="ds4">4. Akses Menu Ilegal</button>
            <button class="btn-outline p2-disaster-btn" data-disaster="ds5">5. Backup Manual Gagal</button>
          </div>
          <div id="p2-disaster-card">
            <!-- Rendered via js/app.js -->
          </div>
        </div>
      </div>
    </section>


    <!-- ====================================================================
         VIEW: PRAKTIKUM 3 (PEMETAAN PROSES BISNIS & APPROVAL)
         ==================================================================== -->
    <section id="p3" class="tab-pane">
      <!-- Header Banner -->
      <div class="module-banner" style="--module-accent: #059669;">
        <div class="module-info">
          <div class="module-badge-num">3</div>
          <div>
            <h2>Praktikum 3: Pemetaan Proses Bisnis & Alur Persetujuan</h2>
            <p>Studi Kasus: Pengadaan Bahan Praktik Laboratorium Politeknik META Industri</p>
          </div>
        </div>
        <button class="btn-outline" onclick="navigateToTab('beranda')">← Kembali ke Beranda</button>
      </div>

      <!-- Sub-Tabs Navigation -->
      <div class="subtabs-bar" data-module="p3">
        <button class="subtab-btn active" data-subtab="p3-sub-asis">1. Kelemahan As-Is</button>
        <button class="subtab-btn" data-subtab="p3-sub-tobe">2. Diagram To-Be ERP</button>
        <button class="subtab-btn" data-subtab="p3-sub-rules">3. Aturan Bisnis & RACI</button>
        <button class="subtab-btn" data-subtab="p3-sub-simulator">4. Simulator Otorisasi</button>
        <button class="subtab-btn" data-subtab="p3-sub-darurat">5. Kondisi Khusus: Nilai Naik</button>
      </div>

      <!-- Subtab 1: Kelemahan As-Is -->
      <div id="p3-sub-asis" class="subtab-content active">
        <div class="clean-card"><div class="card-title-bar"><h3>Diagram As-Is (Proses Manual)</h3><span class="tag tag-red">Merah = berisiko salah/terlambat</span></div><div style="display:flex;flex-wrap:wrap;gap:8px;align-items:stretch;"><div style="flex:1 1 130px;border:1px solid #dc2626;border-radius:8px;padding:8px;font-size:0.78rem;background:#fef2f2;">1. Dosen minta bahan via WhatsApp/kertas<br>⚠️ tanpa identitas &amp; nomor dokumen</div><div style="flex:1 1 130px;border:1px solid #dc2626;border-radius:8px;padding:8px;font-size:0.78rem;background:#fef2f2;">2. Ka.Lab verifikasi berdasar perkiraan<br>⚠️ tanpa data stok</div><div style="flex:1 1 130px;border:1px solid #dc2626;border-radius:8px;padding:8px;font-size:0.78rem;background:#fef2f2;">3. Gudang cek stok manual<br>⚠️ stok tidak real-time, lambat</div><div style="flex:1 1 130px;border:1px solid #dc2626;border-radius:8px;padding:8px;font-size:0.78rem;background:#fef2f2;">4. Pembelian pilih pemasok<br>⚠️ tanpa pembanding, bisa beli ganda</div><div style="flex:1 1 130px;border:1px solid #dc2626;border-radius:8px;padding:8px;font-size:0.78rem;background:#fef2f2;">5. Pimpinan setuju (tanda tangan/chat)<br>⚠️ antre, tanpa jejak</div><div style="flex:1 1 130px;border:1px solid #dc2626;border-radius:8px;padding:8px;font-size:0.78rem;background:#fef2f2;">6. Gudang terima barang (foto chat)<br>⚠️ tanpa GRN</div><div style="flex:1 1 130px;border:1px solid #dc2626;border-radius:8px;padding:8px;font-size:0.78rem;background:#fef2f2;">7. Keuangan bayar<br>⚠️ tanpa pencocokan PO-GRN-Invoice</div></div></div>
        <div class="clean-card">
          <div class="card-title-bar">
            <h3>Identifikasi Kelemahan Proses Manual Pengadaan Bahan Praktik (As-Is)</h3>
            <span class="tag tag-red">Evaluasi Masalah</span>
          </div>
          <p style="font-size:0.86rem; color:var(--text-muted); margin-bottom:14px;">
            Proses manual via WhatsApp menyebabkan penumpukan bahan, pembelian ganda, dan tagihan terlambat:
          </p>
          <div class="table-wrap">
            <table class="clean-table">
              <thead>
                <tr>
                  <th>Kelemahan Proses</th>
                  <th>Penyebab Mendasar</th>
                  <th>Dampak Terhadap Laboratorium Kampus</th>
                </tr>
              </thead>
              <tbody id="p3-asis-defects-body">
                <!-- Rendered via js/app.js -->
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <!-- Subtab 2: Diagram To-Be ERP -->
      <div id="p3-sub-tobe" class="subtab-content">
        <div class="clean-card"><div class="card-title-bar"><h3>Alur To-Be Lengkap (7 Langkah Sesuai Ketentuan)</h3></div><ol style="font-size:0.84rem;padding-left:20px;line-height:1.7;"><li><strong>Dosen</strong> membuat e-Requisition (identitas pengaju, mata kuliah wajib - BR-01).</li><li><strong>Kepala Lab</strong> memverifikasi kebutuhan di sistem.</li><li><strong>Gudang/ERP</strong> memeriksa stok otomatis; jika cukup dialihkan jadi Material Issue (BR-02).</li><li><strong>Pembelian</strong> membandingkan penawaran dan memilih pemasok, lalu membuat PO.</li><li><strong>Pimpinan</strong> menyetujui sesuai nilai (BR-03); bila nilai naik berlaku BR-05.</li><li><strong>Gudang</strong> menerima barang dan membuat GRN terhadap PO.</li><li><strong>Keuangan</strong> membayar setelah 3-way match PO = GRN = Invoice (BR-04).</li></ol>
<p style="font-size:0.84rem;"><strong>Mengapa lebih baik:</strong> setiap langkah punya pemilik dan jejak digital, stok diperiksa sebelum beli (mencegah pembelian ganda), persetujuan bertingkat otomatis, pembayaran hanya dengan dokumen cocok sehingga kesalahan dan keterlambatan berkurang.</p></div>
        <div class="clean-card">
          <div class="card-title-bar">
            <h3>Rancangan Alur Pengadaan To-Be ERP Terintegrasi</h3>
            <span class="tag tag-green">Standarisasi Digital</span>
          </div>
          <div class="flow-diagram" style="background:#f0fdf4; border-color:#bbf7d0;">
            <div class="flow-step">
              <strong>1. E-Requisition</strong>
              <span style="font-size:0.75rem; color:#64748b;">Dosen Tag Silabus</span>
            </div>
            <div class="flow-arrow" style="color:#059669;">➔</div>
            <div class="flow-step">
              <strong>2. Cek Saldo Otomatis</strong>
              <span style="font-size:0.75rem; color:#64748b;">Sistem Cek Gudang</span>
            </div>
            <div class="flow-arrow" style="color:#059669;">➔</div>
            <div class="flow-step">
              <strong>3. Approval Berjenjang</strong>
              <span style="font-size:0.75rem; color:#64748b;">Ka.Lab / Pudir / Direktur</span>
            </div>
            <div class="flow-arrow" style="color:#059669;">➔</div>
            <div class="flow-step">
              <strong>4. Penerimaan & Barcode</strong>
              <span style="font-size:0.75rem; color:#64748b;">Gudang Scan GRN</span>
            </div>
            <div class="flow-arrow" style="color:#059669;">➔</div>
            <div class="flow-step">
              <strong>5. 3-Way Match & Bayar</strong>
              <span style="font-size:0.75rem; color:#64748b;">PO = GRN = Invoice</span>
            </div>
          </div>
        </div>
      </div>

      <!-- Subtab 3: Aturan Bisnis & RACI -->
      <div id="p3-sub-rules" class="subtab-content">
        <div class="clean-card">
          <div class="card-title-bar">
            <h3>Aturan Bisnis Baku & Matriks RACI</h3>
            <span class="tag tag-blue">Tata Kelola</span>
          </div>
          <div style="display:grid; grid-template-columns: 1fr 1fr; gap:18px;">
            <div>
              <strong style="font-size:0.9rem; color:var(--text-main); display:block; margin-bottom:10px;">
                5 Aturan Bisnis Wajib (Business Rules)
              </strong>
              <div id="p3-business-rules-list">
                <!-- Rendered via js/app.js -->
              </div>
            </div>
            <div>
              <strong style="font-size:0.9rem; color:var(--text-main); display:block; margin-bottom:10px;">
                Matriks Tanggung Jawab (RACI Matrix)
              </strong>
              <div class="table-wrap">
                <table class="clean-table" style="font-size:0.78rem;">
                  <thead>
                    <tr>
                      <th>Aktivitas</th>
                      <th>Dosen</th>
                      <th>Ka.Lab</th>
                      <th>Gudang</th>
                      <th>Beli</th>
                      <th>Pimpinan</th>
                      <th>Keu</th>
                    </tr>
                  </thead>
                  <tbody id="p3-raci-body">
                    <!-- Rendered via js/app.js -->
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Subtab 4: Simulator Otorisasi -->
      <div id="p3-sub-simulator" class="subtab-content">
        <div class="clean-card">
          <div class="card-title-bar">
            <h3>Simulator Wewenang Persetujuan Dinamis</h3>
            <span class="tag tag-amber">Uji Interaktif</span>
          </div>
          <p style="font-size:0.86rem; color:var(--text-muted); margin-bottom:14px;">
            Geser nilai nominal pengadaan untuk melihat pejabat yang berwenang memberikan otorisasi:
          </p>

          <div style="margin-bottom:16px;">
            <label class="form-label" for="p3-sim-nominal">
              Nilai Pengadaan: <span id="p3-sim-nominal-display" style="color:var(--brand-primary); font-weight:800; font-size:1.05rem;">Rp 1.800.000</span>
            </label>
            <input type="range" id="p3-sim-nominal" min="500000" max="25000000" step="100000" value="1800000" style="width:100%;">
          </div>

          <div id="p3-approval-path-box" style="margin-bottom:14px;">
            <!-- Rendered via js/app.js -->
          </div>

          <button id="p3-trigger-spike-btn" class="btn-outline">
            ⚠️ Uji Skenario Dosen: Harga Naik Pasca Penawaran (+Rp 900.000)
          </button>
        </div>
      </div>

      <!-- Subtab 5: Pengadaan Darurat -->
      <div id="p3-sub-darurat" class="subtab-content">
        <div class="clean-card">
          <div class="card-title-bar"><h3>Simulasi Kondisi Khusus: Nilai Pembelian Naik Setelah Penawaran Terbaru</h3><span class="tag tag-amber">Sesuai Soal D</span></div>
          <p style="font-size:0.86rem;">Contoh: PO senilai Rp 1.800.000 sudah disetujui Ka.Lab (Level 1). Penawaran terbaru menaikkan nilai menjadi Rp 2.700.000.</p>
          <ul style="font-size:0.84rem;padding-left:20px;line-height:1.7;"><li>Kenaikan 50% (&gt; 10%) dan melewati ambang Rp 2.000.000 (Level 1 menjadi Level 2).</li><li><strong>Keputusan:</strong> persetujuan sebelumnya TIDAK berlaku; PO diajukan ulang ke Ka.Lab + Pudir II Keuangan (aturan BR-03 dan BR-05).</li><li>Alasan: otorisasi diberikan atas nilai tertentu; nilai baru berada di luar wewenang pemberi approval awal. Gunakan tombol uji di tab 4 untuk mencoba kenaikan lain.</li></ul>
        </div>
      </div>
    </section>


    <!-- ====================================================================
         VIEW: PRAKTIKUM 4 (KONFIGURASI DAN SIMULASI MODUL KEUANGAN)
         ==================================================================== -->
    <section id="p4" class="tab-pane">
      <!-- Header Banner -->
      <div class="module-banner" style="--module-accent: #d97706;">
        <div class="module-info">
          <div class="module-badge-num">4</div>
          <div>
            <h2>Praktikum 4: Konfigurasi dan Simulasi Modul Keuangan ERP</h2>
            <p>PT Mekar Komponen • Kas Awal Rp 30.000.000 • Jurnal, Buku Besar, Neraca Saldo, & Audit Trail</p>
          </div>
        </div>
        <button class="btn-outline" onclick="navigateToTab('beranda')">← Kembali ke Beranda</button>
      </div>

      <!-- Status Alert -->
      <div id="p4-status-banner" class="clean-callout callout-blue">
        <!-- Rendered via js/app.js -->
      </div>

      <!-- Financial KPI Boxes -->
      <div class="kpi-grid">
        <div class="kpi-box">
          <span class="label">Kas (1101)</span>
          <div class="val" id="p4-kpi-kas">Rp 30.500.000</div>
          <span class="desc">Awal: Rp 30 Juta</span>
        </div>
        <div class="kpi-box">
          <span class="label">Piutang (1102)</span>
          <div class="val" id="p4-kpi-piutang">Rp 7.000.000</div>
          <span class="desc">Klaim Konsumen</span>
        </div>
        <div class="kpi-box">
          <span class="label">Persediaan (1103)</span>
          <div class="val" id="p4-kpi-persediaan">Rp 8.000.000</div>
          <span class="desc">Bahan Baku Masuk</span>
        </div>
        <div class="kpi-box">
          <span class="label">Utang Usaha (2101)</span>
          <div class="val" id="p4-kpi-utang" style="color:#b91c1c;">Rp 5.000.000</div>
          <span class="desc">Kewajiban Supplier</span>
        </div>
        <div class="kpi-box">
          <span class="label">Penjualan (4101)</span>
          <div class="val" id="p4-kpi-penjualan" style="color:#047857;">Rp 12.000.000</div>
          <span class="desc">Pendapatan</span>
        </div>
        <div class="kpi-box">
          <span class="label">Beban Operasional (5101)</span>
          <div class="val" id="p4-kpi-beban">Rp 1.500.000</div>
          <span class="desc">Operasional</span>
        </div>
      </div>

      <!-- Sub-Tabs Navigation -->
      <div class="subtabs-bar" data-module="p4">
        <button class="subtab-btn active" data-subtab="p4-sub-coa">1. Bagan Akun (COA)</button>
        <button class="subtab-btn" data-subtab="p4-sub-jurnal">2. Jurnal Umum Otomatis</button>
        <button class="subtab-btn" data-subtab="p4-sub-ledger">3. Buku Besar</button>
        <button class="subtab-btn" data-subtab="p4-sub-neraca">4. Neraca Saldo (Trial Balance)</button>
        <button class="subtab-btn" data-subtab="p4-sub-koreksi">5. Deteksi Duplikasi & Koreksi</button>
      </div>

      <!-- Subtab 1: COA -->
      <div id="p4-sub-coa" class="subtab-content active">
        <div class="clean-card">
          <div class="card-title-bar">
            <h3>Konfigurasi Bagan Akun (Chart of Accounts)</h3>
            <span class="tag tag-blue">Modul FI</span>
          </div>
          <div class="table-wrap">
            <table class="clean-table">
              <thead>
                <tr>
                  <th>Kode Akun</th>
                  <th>Nama Akun</th>
                  <th>Klasifikasi</th>
                  <th>Saldo Normal</th>
                  <th class="text-right">Saldo Awal</th>
                  <th>Fungsi dalam Sistem ERP</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td class="font-mono"><strong>1101</strong></td>
                  <td><strong>Kas</strong></td>
                  <td><span class="tag tag-blue">Aset Lancar</span></td>
                  <td>Debit</td>
                  <td class="text-right font-mono">Rp 30.000.000</td>
                  <td>Penerimaan & pengeluaran kas operasional.</td>
                </tr>
                <tr>
                  <td class="font-mono"><strong>1102</strong></td>
                  <td><strong>Piutang Usaha</strong></td>
                  <td><span class="tag tag-blue">Aset Lancar</span></td>
                  <td>Debit</td>
                  <td class="text-right font-mono">Rp 0</td>
                  <td>Tercatat otomatis saat faktur penjualan terbit.</td>
                </tr>
                <tr>
                  <td class="font-mono"><strong>1103</strong></td>
                  <td><strong>Persediaan Bahan Baku</strong></td>
                  <td><span class="tag tag-blue">Aset Lancar</span></td>
                  <td>Debit</td>
                  <td class="text-right font-mono">Rp 0</td>
                  <td>Bertambah otomatis saat validasi penerimaan barang (GRN).</td>
                </tr>
                <tr>
                  <td class="font-mono"><strong>2101</strong></td>
                  <td><strong>Utang Usaha</strong></td>
                  <td><span class="tag tag-amber">Kewajiban</span></td>
                  <td>Kredit</td>
                  <td class="text-right font-mono">Rp 0</td>
                  <td>Tercatat otomatis saat faktur tagihan supplier masuk.</td>
                </tr>
                <tr>
                  <td class="font-mono"><strong>3101</strong></td>
                  <td><strong>Modal Pemilik</strong></td>
                  <td><span class="tag tag-gray">Ekuitas</span></td>
                  <td>Kredit</td>
                  <td class="text-right font-mono">Rp 30.000.000</td>
                  <td>Ekuitas saldo awal pembukaan simulasi.</td>
                </tr>
                <tr>
                  <td class="font-mono"><strong>4101</strong></td>
                  <td><strong>Penjualan Produk</strong></td>
                  <td><span class="tag tag-green">Pendapatan</span></td>
                  <td>Kredit</td>
                  <td class="text-right font-mono">Rp 0</td>
                  <td>Pengakuan pendapatan atas transaksi penjualan.</td>
                </tr>
                <tr>
                  <td class="font-mono"><strong>5101</strong></td>
                  <td><strong>Beban Operasional</strong></td>
                  <td><span class="tag tag-red">Beban</span></td>
                  <td>Debit</td>
                  <td class="text-right font-mono">Rp 0</td>
                  <td>Mencatat biaya listrik dan operasional kantor.</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <!-- Subtab 2: Jurnal Umum -->
      <div id="p4-sub-jurnal" class="subtab-content">
        <div class="clean-card">
          <div class="card-title-bar">
            <h3>Jurnal Umum Otomatis (General Journal)</h3>
            <div style="display:flex; gap:6px;">
              <button id="p4-btn-reset" class="btn-outline" style="font-size:0.78rem;">🔄 Reset Standar</button>
              <button id="p4-btn-duplicate" class="btn-outline" style="font-size:0.78rem; color:#b91c1c;">⚠️ Uji Dobel Input</button>
              <button id="p4-btn-correct" class="btn-outline" style="font-size:0.78rem; color:#047857;">✓ Jurnal Koreksi</button>
            </div>
          </div>
          <div class="table-wrap">
            <table class="clean-table">
              <thead>
                <tr>
                  <th>No Ref</th>
                  <th>Keterangan Akun</th>
                  <th>Kode</th>
                  <th class="text-right">Debit (Rp)</th>
                  <th class="text-right">Kredit (Rp)</th>
                  <th>Alasan Akuntansi ERP</th>
                </tr>
              </thead>
              <tbody id="p4-journal-body">
                <!-- Rendered via js/app.js -->
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <!-- Subtab 3: Neraca Saldo -->
      <div id="p4-sub-neraca" class="subtab-content">
        <div class="clean-card">
          <div class="card-title-bar">
            <h3>Neraca Saldo (Trial Balance)</h3>
            <span class="tag tag-green">Keseimbangan Buku Besar</span>
          </div>
          <div class="table-wrap">
            <table class="clean-table">
              <thead>
                <tr>
                  <th>Kode</th>
                  <th>Nama Akun</th>
                  <th>Klasifikasi</th>
                  <th class="text-right">Debit (Rp)</th>
                  <th class="text-right">Kredit (Rp)</th>
                </tr>
              </thead>
              <tbody id="p4-trial-balance-body">
                <!-- Rendered via js/app.js -->
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <div id="p4-sub-ledger" class="subtab-content"><div class="clean-card"><div class="card-title-bar"><h3>Buku Besar (General Ledger)</h3><span class="tag tag-blue">Saldo berjalan per akun</span></div><div id="p4-ledger-box"></div></div></div>

      <!-- Subtab 5: Deteksi Duplikasi & Koreksi -->
      <div id="p4-sub-koreksi" class="subtab-content">
        <div class="clean-card">
          <div class="card-title-bar">
            <h3>Pengujian Kesalahan Duplikasi Pembayaran & Audit Trail</h3>
            <span class="tag tag-red">Uji Integritas</span>
          </div>
          <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap:16px;">
            <div style="background:#fef2f2; border:1px solid #fee2e2; border-radius:var(--radius-sm); padding:16px;">
              <strong style="font-size:0.9rem; color:#991b1b; display:block; margin-bottom:6px;">
                🔍 Cara Deteksi & Dampak Kesalahan
              </strong>
              <ul style="font-size:0.82rem; color:#7f1d1d; padding-left:18px; line-height:1.6;">
                <li><strong>Deteksi:</strong> Selisih rekonsiliasi bank riil dengan buku kas, serta peringatan voucher duplikat.</li>
                <li><strong>Dampak:</strong> Saldo Kas mengecil tidak wajar menjadi Rp 27.500.000 (-Rp 3 Jt) dan Utang Usaha tersisa Rp 2.000.000 padahal seharusnya Rp 5.000.000.</li>
              </ul>
            </div>
            <div style="background:#f0fdf4; border:1px solid #bbf7d0; border-radius:var(--radius-sm); padding:16px;">
              <strong style="font-size:0.9rem; color:#065f46; display:block; margin-bottom:6px;">
                🛡️ Prosedur Koreksi Tanpa Menghapus Jejak
              </strong>
              <ul style="font-size:0.82rem; color:#064e3b; padding-left:18px; line-height:1.6;">
                <li><strong>Aturan Audit:</strong> Baris transaksi yang salah TIDAK BOLEH dihapus demi kepatuhan PSAK.</li>
                <li><strong>Jurnal Pembalik (Reversing Entry):</strong> Menjurnal <code>(Dr) Kas Rp 3.000.000 / (Cr) Utang Usaha Rp 3.000.000</code> bertaut ke nomor voucher awal.</li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </section>


    <!-- ====================================================================
         VIEW: PRAKTIKUM 5 (SCM DAN PERENCANAAN KEBUTUHAN MATERIAL - MRP)
         ==================================================================== -->
    <section id="p5" class="tab-pane">
      <!-- Header Banner -->
      <div class="module-banner" style="--module-accent: #dc2626;">
        <div class="module-info">
          <div class="module-badge-num">5</div>
          <div>
            <h2>Praktikum 5: Konfigurasi SCM dan Pembelian Material (MRP)</h2>
            <p>PT Maju Presisi • Produksi 300 Unit KPP-300 • BOM • Lead Time Bottleneck • Delay Shock Test</p>
          </div>
        </div>
        <button class="btn-outline" onclick="navigateToTab('beranda')">← Kembali ke Beranda</button>
      </div>

      <!-- Sub-Tabs Navigation -->
      <div class="subtabs-bar" data-module="p5">
        <button class="subtab-btn active" data-subtab="p5-sub-bom">1. Data Master & BOM</button>
        <button class="subtab-btn" data-subtab="p5-sub-mrp">2. Kalkulator MRP</button>
        <button class="subtab-btn" data-subtab="p5-sub-pr">3. Permintaan Pembelian (PR)</button>
        <button class="subtab-btn" data-subtab="p5-sub-grn">4. Penerimaan Parsial</button>
        <button class="subtab-btn" data-subtab="p5-sub-shock">5. Uji Keterlambatan Vendor B</button>
      </div>

      <!-- Subtab 1: BOM -->
      <div id="p5-sub-bom" class="subtab-content active">
        <div class="clean-card">
          <div class="card-title-bar">
            <h3>Konfigurasi Master Data & Bill of Materials (BOM)</h3>
            <span class="tag tag-blue">Struktur Produk</span>
          </div>
          <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap:14px;">
            <div style="background:#f8fafc; border:1px solid var(--border-subtle); border-radius:var(--radius-sm); padding:16px;">
              <span class="tag tag-green" style="margin-bottom:6px;">Produk Jadi (FG)</span>
              <strong style="display:block; font-size:0.95rem; color:var(--text-main);">KPP-300: Poros Mesin Presisi</strong>
              <p style="font-size:0.8rem; color:var(--text-muted); margin-top:4px;">
                Rencana Output: <strong>300 Unit</strong><br>
                Target Selesai: <strong>6 Hari Kerja</strong>
              </p>
            </div>
            <div style="background:#f8fafc; border:1px solid var(--border-subtle); border-radius:var(--radius-sm); padding:16px;">
              <span class="tag tag-blue" style="margin-bottom:6px;">Bahan Baku A (Rasio: 3)</span>
              <strong style="display:block; font-size:0.95rem; color:var(--text-main);">Aluminium Billet AL-6061</strong>
              <p style="font-size:0.8rem; color:var(--text-muted); margin-top:4px;">
                Stok Tersedia: <strong>400 Unit</strong><br>
                On-Order: <strong>100 Unit</strong> (Lead Time: 4 Hari Kerja)
              </p>
            </div>
            <div style="background:#f8fafc; border:1px solid var(--border-subtle); border-radius:var(--radius-sm); padding:16px;">
              <span class="tag tag-amber" style="margin-bottom:6px;">Bahan Baku B (Rasio: 2)</span>
              <strong style="display:block; font-size:0.95rem; color:var(--text-main);">Baut High-Tensile HT-88</strong>
              <p style="font-size:0.8rem; color:var(--text-muted); margin-top:4px;">
                Stok Tersedia: <strong>250 Unit</strong><br>
                On-Order: <strong>0 Unit</strong> (Lead Time: 7 Hari Kerja)
              </p>
            </div>
          </div>
        </div>
      </div>

      <!-- Subtab 2: Kalkulator MRP -->
      <div id="p5-sub-mrp" class="subtab-content">
        <div class="clean-card">
          <div class="card-title-bar">
            <h3>Mesin Kalkulasi Kebutuhan Material (MRP Engine)</h3>
            <span class="tag tag-green">Perhitungan Otomatis</span>
          </div>
          
          <div style="display:flex; gap:12px; align-items:flex-end; flex-wrap:wrap; margin-bottom:14px;">
            <div>
              <label class="form-label" for="p5-prod-qty">Rencana Output (Unit):</label>
              <input type="number" id="p5-prod-qty" class="form-input" value="300" min="50" max="2000" style="width:160px;">
            </div>
            <div>
              <label class="form-label" for="p5-target-days">Batas Waktu (Hari Kerja):</label>
              <input type="number" id="p5-target-days" class="form-input" value="6" min="1" max="30" style="width:160px;">
            </div>
            <button id="p5-btn-calc-mrp" class="btn-primary">
              ⚡ Hitung Ulang MRP
            </button>
          </div>

          <div class="table-wrap">
            <table class="clean-table">
              <thead>
                <tr>
                  <th>Kode</th>
                  <th>Nama Bahan</th>
                  <th class="text-center">BOM Rasio</th>
                  <th class="text-right">Kebutuhan Bruto</th>
                  <th class="text-right">Stok Fisik</th>
                  <th class="text-right">On-Order</th>
                  <th class="text-right">Kebutuhan Bersih</th>
                  <th class="text-center">Lead Time vs Deadline</th>
                  <th>Rekomendasi Pembelian</th>
                </tr>
              </thead>
              <tbody id="p5-mrp-table-body">
                <!-- Rendered via js/app.js -->
              </tbody>
            </table>
          </div>

          <div id="p5-mrp-conclusion" style="margin-top:14px;">
            <!-- Rendered via js/app.js -->
          </div>
        </div>
      </div>

      <div id="p5-sub-pr" class="subtab-content"><div class="clean-card"><div class="card-title-bar"><h3>Simulasi Permintaan Pembelian (PR) dari Hasil MRP</h3><span class="tag tag-amber">Tahap 3</span></div><p style="font-size:0.84rem;">Kebutuhan bersih hasil MRP otomatis menjadi PR. Aturan pemesanan: lot-for-lot, MOQ 50 unit, satuan Unit, gudang GD-01 Gudang Bahan Baku.</p><div id="p5-pr-box" style="overflow-x:auto;"></div></div></div>

      <!-- Subtab 3: Penerimaan Parsial -->
      <div id="p5-sub-grn" class="subtab-content">
        <div class="clean-card">
          <div class="card-title-bar">
            <h3>Simulasi Penerimaan Barang Parsial di Gudang (GRN)</h3>
            <span class="tag tag-blue">Siklus Gudang</span>
          </div>
          <p style="font-size:0.86rem; color:var(--text-muted); margin-bottom:12px;">
            Simulasikan kedatangan sebagian barang dari supplier (misal datang 200 unit Bahan A terlebih dahulu):
          </p>
          <div style="display:flex; gap:12px; align-items:flex-end; flex-wrap:wrap; margin-bottom:12px;">
            <div>
              <label class="form-label" for="p5-receive-qty">Jumlah Unit Diterima:</label>
              <input type="number" id="p5-receive-qty" class="form-input" value="200" min="50" max="400" style="width:180px;">
            </div>
            <button id="p5-btn-receive-partial" class="btn-primary">
              📦 Proses Penerimaan Fisik (GRN)
            </button>
          </div>
          <div id="p5-grn-log" class="output-card" style="display:none;"></div>
        </div>
      </div>

      <!-- Subtab 4: Delay Shock Test -->
      <div id="p5-sub-shock" class="subtab-content">
        <div class="clean-card">
          <div class="card-title-bar">
            <h3>Pengujian Perubahan Kondisi: Keterlambatan Supplier B (Shock Test)</h3>
            <span class="tag tag-red">Pengambilan Keputusan</span>
          </div>
          <div class="clean-callout callout-red">
            <strong>KONDISI KRITIS DOSEN:</strong> Supplier Bahan B mengabarkan pengiriman molor menjadi <strong>8 hari kerja</strong>, sementara produksi wajib tuntas dalam <strong>6 hari kerja</strong>.
          </div>
          <p style="font-size:0.86rem; color:var(--text-muted); margin-bottom:14px;">
            Matriks evaluasi 4 opsi keputusan manajerial dengan menimbang waktu, biaya, dan risiko:
          </p>
          <div id="p5-shock-options-container">
            <!-- Rendered via js/app.js -->
          </div>
          <div class="clean-callout callout-green" style="margin-top:14px;">
            <strong>Rekomendasi Strategi Terbaik:</strong> Kombinasikan Opsi 1 (Split Production) menggunakan 250 unit Bahan B di gudang untuk segera merakit 125 unit produk pertama pada hari 1-3, dan Opsi 2 (Pengadaan kilat supplier sekunder) untuk sisa 175 unit produk agar seluruh 300 unit selesai sebelum batas 6 hari kerja.
          </div>
        </div>
      </div>
    </section>

  </main>

  <!-- Kartu profil khusus cetak PDF -->
  <section id="print-profile-sheet" aria-hidden="true">
    <div class="pps-head"><div class="pps-logo">META ERP Portal</div><div class="pps-sub">Politeknik META Industri • TRPL PL/4008</div></div>
    <h2>Profil Akun Pengguna</h2>
    <div class="pps-card">
      <div class="pps-avatar" id="pps-avatar">⭐</div>
      <table>
        <tr><th>Nama Lengkap</th><td id="pps-name">-</td></tr>
        <tr><th>Username</th><td id="pps-user">-</td></tr>
        <tr><th>Peran</th><td id="pps-role">-</td></tr>
        <tr><th>Departemen</th><td id="pps-dept">-</td></tr>
        <tr><th>Dicetak pada</th><td id="pps-date">-</td></tr>
      </table>
    </div>
    <p class="pps-foot">Dokumen ini dibuat otomatis oleh META ERP Enterprise Suite.</p>
  </section>

  <!-- Clean Footer -->
  <footer class="site-footer">
    <div class="footer-content">
      <div>
        <strong>Politeknik META Industri Cikarang</strong> — Program Studi Teknologi Rekayasa Perangkat Lunak (TRPL)
      </div>
      <div>
        Enterprise Resource Planning (PL/4008) • Dosen: Adie Kusna Wibowo • UTS 2026/2027
      </div>
    </div>
  </footer>

  <!-- ====================================================================
       MODAL 2: DATABASE DIAGNOSTICS & SYNC STATUS
       ==================================================================== -->
  <div id="db-modal" class="erp-modal-overlay">
    <div class="erp-modal-box">
      <div class="erp-modal-header">
        <h3>🗄️ Status Database &amp; Sinkronisasi Data</h3>
        <button id="db-modal-close" class="erp-modal-close" title="Tutup">&times;</button>
      </div>
      <div class="erp-modal-body">
        <div id="db-modal-status-box" style="margin-bottom:16px;">
          <!-- Rendered via js/app.js -->
        </div>

        <div style="margin-bottom:16px;">
          <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:8px;">
            <strong style="font-size:0.92rem; color:var(--text-main);">Daftar Tabel Database (P1 s/d P5 &amp; Akun):</strong>
            <button id="btn-retry-db" class="btn-outline" style="font-size:0.78rem; padding:4px 10px;">
              🔄 Cek Ulang Koneksi
            </button>
          </div>
          <div class="table-wrap">
            <table class="clean-table">
              <thead>
                <tr>
                  <th>Nama Tabel / Modul</th>
                  <th>Status</th>
                  <th class="text-right">Jumlah Data</th>
                </tr>
              </thead>
              <tbody id="db-modal-table-list">
                <!-- Rendered via js/app.js -->
              </tbody>
            </table>
          </div>
        </div>

        <!-- Panduan Integrasi cPanel -->
        <div style="background:#f8fafc; border:1px solid var(--border-subtle); border-radius:var(--radius-sm); padding:14px; font-size:0.83rem; color:var(--text-muted); line-height:1.6;">
          <strong style="color:var(--text-main); display:block; margin-bottom:4px;">💡 Panduan Integrasi MySQL di cPanel Hosting:</strong>
          <ol style="padding-left:18px; margin:0;">
            <li>Buka <strong>cPanel</strong> ➔ menu <strong>MySQL Databases</strong>, buat database (misal: <code>pagitrpl_ERPyazid</code>).</li>
            <li>Buka <strong>phpMyAdmin</strong>, pilih database tersebut, lalu klik <strong>Import</strong> dan upload file <code>database.sql</code>.</li>
            <li>Buka file <code>api/config.php</code> di File Manager, sesuaikan <code>DB_USER</code> dan <code>DB_PASS</code> sesuai kredensial MySQL cPanel Anda.</li>
            <li>Setelah diatur, klik tombol <strong>"Cek Ulang Koneksi"</strong> di atas. Indikator akan otomatis berubah hijau (🟢 MySQL Terhubung).</li>
          </ol>
        </div>
      </div>
    </div>
  </div>

  <!-- Scripts External Modular -->
  <script src="js/data.js"></script>
  <script src="js/app.js"></script>
</body>
</html>
