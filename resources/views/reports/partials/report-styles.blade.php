<style>
  :root {
    --report-primary: #d63384;
    --report-primary-soft: #f9e7f1;
    --report-dark: #2f2f3a;
    --report-muted: #8a8894;
    --report-surface: #ffffff;
    --report-bg: #f7f4f8;
    --report-border: #efe5ec;
  }

  .report-page {
    background: var(--report-bg);
    border-radius: 0.75rem;
    padding: 0.25rem;
  }

  /* Report page header */
  .report-page-header {
    background: var(--report-surface);
    color: var(--report-dark);
    border: 1px solid var(--report-border);
    border-radius: 0.75rem;
    box-shadow: 0 8px 26px rgba(214, 51, 132, 0.08);
    margin-bottom: 1rem;
  }
  .report-page-header .card-title h1 {
    color: var(--report-dark);
    font-weight: 700;
    margin: 0;
    font-size: 1.4rem;
  }

  /* Stats cards */
  .report-stat-sales {
    background: linear-gradient(135deg, #ef72b3 0%, #d63384 55%, #b7206a 100%);
    color: #fff !important;
    border: none;
    border-radius: 0.75rem;
    box-shadow: 0 10px 20px rgba(214, 51, 132, 0.25);
  }
  .report-stat-sales .card-body h3 {
    color: #fff !important;
    font-weight: 600;
    opacity: 0.95;
  }

  .report-stat-expenses {
    background: linear-gradient(135deg, #ff8dbb 0%, #f05292 55%, #d63384 100%);
    color: #fff !important;
    border: none;
    border-radius: 0.75rem;
    box-shadow: 0 10px 20px rgba(240, 82, 146, 0.25);
  }
  .report-stat-expenses .card-body h3 {
    color: #fff !important;
    font-weight: 600;
    opacity: 0.95;
  }

  .report-stat-sales .card-body,
  .report-stat-expenses .card-body {
    padding: 1.1rem 1.25rem;
    font-size: 1.1rem;
    font-weight: 600;
  }

  /* Payment methods card */
  .report-payment-card {
    background: var(--report-surface);
    color: var(--report-dark) !important;
    border: 1px solid var(--report-border);
    border-radius: 0.75rem;
    box-shadow: 0 6px 18px rgba(41, 35, 39, 0.06);
  }
  .report-payment-card .card-body h3 {
    color: var(--report-dark) !important;
    font-weight: 600;
  }
  .report-payment-card .table {
    color: var(--report-dark) !important;
  }
  .report-payment-card .table th {
    background: var(--report-primary-soft);
    color: #6d1c4b !important;
    border-color: #f1d7e8;
    font-weight: 600;
  }
  .report-payment-card .table td {
    border-color: #f3eaf1;
    color: var(--report-dark) !important;
  }
  .report-payment-card .table tbody tr:hover {
    background: #fcf5f9;
  }

  /* Search / form card */
  .report-search-card {
    border: 1px solid var(--report-border);
    border-radius: 0.75rem;
    box-shadow: 0 6px 18px rgba(41, 35, 39, 0.06);
  }
  .report-search-card .card-header {
    background: linear-gradient(135deg, #d63384 0%, #ee79b6 100%);
    color: #fff;
    font-weight: 600;
    border-radius: 0.75rem 0.75rem 0 0;
  }

  /* Items/sales table card */
  .report-table-card {
    border-radius: 0.75rem;
    box-shadow: 0 6px 18px rgba(41, 35, 39, 0.06);
    border: 1px solid var(--report-border);
  }
  .report-table-card .card-header {
    background: linear-gradient(135deg, #d63384 0%, #ee79b6 100%);
    color: #fff;
    font-weight: 600;
    border-radius: 0.75rem 0.75rem 0 0;
  }
  .report-table-card .card-header .card-title h3,
  .report-table-card .card-header .btn {
    color: #fff !important;
  }
  .report-table-card .table th {
    background: var(--report-primary-soft);
    color: #6d1c4b;
    font-weight: 600;
    border-bottom: 1px solid #f1d7e8;
  }
  .report-table-card .table tbody tr:nth-child(even) {
    background: #fff;
  }
  .report-table-card .table tbody tr:hover {
    background: #fcf5f9;
  }

  /* Hourly result highlight */
  .report-result-card {
    border: 1px solid var(--report-border);
    border-radius: 0.75rem;
    box-shadow: 0 6px 18px rgba(41, 35, 39, 0.06);
  }
  .report-result-card .card-header {
    background: linear-gradient(135deg, #d63384 0%, #ee79b6 100%);
    color: #fff;
    font-weight: 600;
    border-radius: 0.75rem 0.75rem 0 0;
  }
  .report-result-card .card-body h3 {
    color: var(--report-primary);
    font-weight: 700;
  }

  /* Item report empty state */
  .report-empty-state {
    color: #8f1f58;
    background: #fff3f8;
    border-radius: 0.75rem;
    border: 1px solid #f7d4e8;
  }

  .report-search-card .form-control:focus,
  .report-search-card .custom-select:focus {
    border-color: #e17fb0;
    box-shadow: 0 0 0 0.2rem rgba(214, 51, 132, 0.16);
  }

  .report-search-card .btn-success {
    background: var(--report-primary);
    border-color: var(--report-primary);
  }

  .report-search-card .btn-success:hover {
    background: #bf2c74;
    border-color: #bf2c74;
  }

  .report-table-card .btn-light {
    background: #fff;
    border-color: #fff;
    color: #7a2452 !important;
    font-weight: 600;
  }

  .report-table-card .btn-light:hover {
    background: #fff0f7;
    border-color: #fff0f7;
  }
</style>
