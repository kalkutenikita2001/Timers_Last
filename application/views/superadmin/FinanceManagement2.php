<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Badminton Academy Finance Management</title>

  <!-- libs -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet" />

  <style>
    :root{
      /* unified theme tokens */
      --accent:#ff4040; 
      --accent-dark:#470000; 
      --muted:#f4f6f8;
      --grad:linear-gradient(135deg, var(--accent), var(--accent-dark));
      --grad-soft:linear-gradient(90deg, #ffffff, #fff6f6);
      --sidebar-width:250px; /* sidebar script updates this */
    }
    *,*::before,*::after{ box-sizing:border-box; }
    html,body{ width:100%; max-width:100%; overflow-x:hidden; }
    body{ background:var(--muted); color:#111; font-family:system-ui,-apple-system,Segoe UI,Roboto,Helvetica,Arial; }

    /* layout (sidebar-aware) */
    .dashboard-wrapper{ margin-left:var(--sidebar-width); width:calc(100vw - var(--sidebar-width)); padding:20px; min-height:100vh; transition:.25s; }
    .dashboard-wrapper.minimized{ margin-left:60px; width:calc(100vw - 60px); }
    @media (max-width:991.98px){ .dashboard-wrapper{ margin-left:0 !important; width:100vw; padding:12px; } }

    /* page hero */
    .page-hero{ border-radius:16px; border:1px solid #ffe1e1;
      background: radial-gradient(1000px 320px at -10% -20%, rgba(255,64,64,.22), transparent),
                  radial-gradient(800px 260px at 110% 0%, rgba(71,0,0,.18), transparent),
                  var(--grad-soft);
      box-shadow:0 16px 40px rgba(255,64,64,.08);
      padding:14px 16px; margin-bottom:12px; overflow:hidden;
    }
    .page-title{ font-weight:800; letter-spacing:.2px; }

    /* top toolbar */
    .toolbar{ position:sticky; top:12px; z-index:5; background:#fff; border:1px solid #e9ecef; border-radius:12px; padding:10px; box-shadow:0 8px 24px rgba(0,0,0,.05); overflow:hidden; }
    .btn-ghost{ border:1px solid #e9ecef; background:#fff; }
    .btn-ghost:hover{ background:#f8f8f8; }
    .btn-primary{ background:var(--grad); border:0; font-weight:700; }
    .btn-primary:hover{ filter:brightness(.96); }
    .badge-soft{ background:#fff; border:1px solid #e9ecef; padding:.35rem .6rem; border-radius:999px; }

    /* global search */
    .global-search{ max-width:720px; margin:0 auto; transition:all .25s ease; }
    .global-search .form-control{ height:42px; border-radius:50px; font-size:.9rem; padding-left:.5rem; border-color:#e3e3e3; }
    .global-search .input-group-text{ border-radius:50px 0 0 50px; background:#fff; border-color:#e3e3e3; }
    .global-search .form-control:focus{ border-color:var(--accent); box-shadow:0 0 0 3px rgba(255,64,64,.2); }

    /* card shell */
    .card-lite{ background:#fff; border-radius:14px; border:1px solid #e9ecef; box-shadow:0 6px 20px rgba(0,0,0,.05); overflow:hidden; }

    /* summary cards */
    .summary-card{ background:#fff; border-radius:12px; border:1px solid #e9ecef; box-shadow:0 6px 18px rgba(0,0,0,.06); padding:18px; margin-bottom:18px; }
    .summary-card h3{ color:var(--accent); font-size:1.05rem; font-weight:800; text-align:center; }
    .summary-item{ display:flex; align-items:center; gap:10px; padding:10px; border-radius:10px; border:1px solid #f0f0f0; }
    .summary-item i{ color:var(--accent); width:22px; text-align:center; }
    .summary-item .value{ margin-left:auto; font-weight:800; color:var(--accent); }
    #paid-amount, #pending-amount, #expense-amount{ font-weight:900 !important; font-size:1.25rem !important; color:#d32f2f !important; }

    /* table */
    .table thead th{ position:sticky; top:0; background:#fff; z-index:2; }
    .table-hover tbody tr:hover{ background:rgba(255,64,64,.035); }

    /* section filter band */
    .filter-section{ margin-bottom: 12px; display:flex; align-items:center; gap:10px; flex-wrap:wrap; background:#fff; padding:12px; border-radius:12px; border:1px solid #e9ecef; box-shadow:0 6px 12px rgba(0,0,0,.04); border-left:4px solid #ffb3b3; }
    .filter-section .btn{ border:0; }

    /* nav tabs styled like suite */
    .nav-tabs-lite{ display:flex; gap:8px; }
    .nav-tabs-lite .tab-link{ padding:8px 14px; border-radius:999px; border:1px solid #ffd7d7; background:#fff; color:#8a1b1b; font-weight:600; cursor:pointer; }
    .nav-tabs-lite .tab-link.active{ background:var(--grad); color:#fff; border-color:transparent; }

    @media (max-width: 576px){
      .summary-card h3{ font-size:1rem; }
      .summary-item{ padding:8px; }
    }
  </style>
</head>
<body>
  <?php $this->load->view('superadmin/Include/Sidebar'); ?>
  <?php $this->load->view('superadmin/Include/Navbar'); ?>

  <div class="dashboard-wrapper" id="financeWrap">
    <div class="container-fluid">

      <!-- Hero -->
      <div class="page-hero">
        <div class="d-flex align-items-center justify-content-between gap-2 flex-wrap">
          <div class="page-title h5 mb-0">Finance Management</div>
          <div class="nav-tabs-lite">
            <button class="tab-link active" onclick="showTab('overview')">📊 Overview</button>
            <button class="tab-link" onclick="showTab('income')">💰 Income</button>
            <button class="tab-link" onclick="showTab('expense')">💸 Expenses</button>
          </div>
        </div>
      </div>

      <!-- Toolbar: global search + global filters -->
      <div class="toolbar mb-3">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
          <div class="flex-grow-1">
            <div class="input-group global-search">
              <span class="input-group-text bg-white border-end-0"><i class="fa-solid fa-magnifying-glass"></i></span>
              <input id="search" type="text" class="form-control border-start-0" placeholder="Search everywhere… (student, item, center, category, amount, date)">
            </div>
          </div>
          <div class="d-flex align-items-center gap-2 flex-wrap">
            <select id="date-filter" class="form-select form-select-sm">
              <option value="">All Periods</option>
              <option value="2025-10" selected>Oct 2025</option>
            </select>
            <select id="center-filter" class="form-select form-select-sm">
              <option value="">All Centers</option>
              <option value="Center1">Center 1</option>
              <option value="Center2">Center 2</option>
            </select>
            <span class="badge-soft">Auto-updating</span>
          </div>
        </div>
      </div>

      <!-- Overview -->
      <div id="overview" class="tab-content active">
        <div class="row g-3">
          <div class="col-md-6">
            <div class="summary-card" id="income-summary-card">
              <h3 id="income-title">Income Summary</h3>
              <div class="summary-item">
                <i class="fas fa-check-circle"></i>
                <span>Paid Amount</span>
                <span class="value" id="paid-amount">₹0</span>
              </div>
              <div class="summary-item">
                <i class="fas fa-hourglass-half"></i>
                <span>Pending Amount</span>
                <span class="value" id="pending-amount">₹0</span>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="summary-card" id="expense-summary-card">
              <h3 id="expense-title">Expense Summary</h3>
              <div class="summary-item">
                <i class="fas fa-minus-circle"></i>
                <span>Total Expense</span>
                <span class="value" id="expense-amount">₹0</span>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Income -->
      <div id="income" class="tab-content" style="display:none;">
        <div class="filter-section">
          <label class="mb-0">Additional Filter:</label>
          <select id="filter-type-income" class="form-select form-select-sm" onchange="toggleDateFilter('income')">
            <option value="">None</option>
            <option value="datewise">Date Range</option>
          </select>
          <div id="date-filter-income" style="display:none; gap:6px; align-items:center;">
            <input type="date" id="date-from-income" class="form-control form-control-sm">
            <span>to</span>
            <input type="date" id="date-to-income" class="form-control form-control-sm">
          </div>
          <button class="btn btn-primary btn-sm" onclick="applyFilter('income')">Apply Filter</button>
          <!-- <button class="btn btn-ghost btn-sm" onclick="toggleAddForm('income')">+ Add Income</button> -->
        </div>

        <div class="card-lite p-2">
          <div class="px-2 pb-2 small"><strong>Total Amount:</strong> <span id="income-total">₹0</span> &nbsp; | &nbsp; <strong>Pending:</strong> <span id="income-pending">₹0</span></div>
          <div class="table-responsive">
            <table id="income-table" class="table table-hover align-middle">
              <thead>
                <tr>
                  <th>Student</th>
                  <th>Plan</th>
                  <th>Status</th>
                  <th>Amount</th>
                  <th>Date</th>
                  <th>Center</th>
                </tr>
              </thead>
              <tbody></tbody>
            </table>
          </div>
        </div>

        <div class="card-lite p-3 mt-2 d-none" id="income-add-form">
          <h6 class="fw-bold mb-2">Add New Income Entry</h6>
          <div class="row g-2">
            <div class="col-sm-6 col-md-3"><input type="text" id="inc-name" class="form-control" placeholder="Student Name" required></div>
            <div class="col-sm-6 col-md-3"><input type="text" id="inc-plan" class="form-control" placeholder="Training Plan" required></div>
            <div class="col-sm-6 col-md-3"><input type="number" id="inc-amount" class="form-control" placeholder="Amount (₹)" required></div>
            <div class="col-sm-6 col-md-3">
              <select id="inc-status" class="form-select" required>
                <option value="received">Received</option>
                <option value="pending">Pending</option>
              </select>
            </div>
            <div class="col-sm-6 col-md-3">
              <select id="inc-center" class="form-select" required>
                <option value="Center1">Center 1</option>
                <option value="Center2">Center 2</option>
              </select>
            </div>
          </div>
          <div class="text-end mt-3">
            <button onclick="addIncomeEntry()" class="btn btn-primary">Add Income</button>
            <button onclick="toggleAddForm('income')" class="btn btn-ghost">Cancel</button>
          </div>
        </div>
      </div>

      <!-- Expense -->
      <div id="expense" class="tab-content" style="display:none;">
        <div class="filter-section">
          <label class="mb-0">Additional Filter:</label>
          <select id="filter-type-exp" class="form-select form-select-sm" onchange="toggleDateFilter('expense')">
            <option value="">None</option>
            <option value="datewise">Date Range</option>
          </select>
          <div id="date-filter-exp" style="display:none; gap:6px; align-items:center;">
            <input type="date" id="date-from-exp" class="form-control form-control-sm">
            <span>to</span>
            <input type="date" id="date-to-exp" class="form-control form-control-sm">
          </div>
          <button class="btn btn-primary btn-sm" onclick="applyFilter('expense')">Apply Filter</button>
          <button class="btn btn-ghost btn-sm" onclick="toggleAddForm('expense')">+ Add Expense</button>
        </div>

        <div class="card-lite p-2">
          <div class="px-2 pb-2 small"><strong>Total Expenses:</strong> <span id="expense-total">₹0</span></div>
          <div class="table-responsive">
            <table id="expense-table" class="table table-hover align-middle">
              <thead>
                <tr>
                  <th>Item</th>
                  <th>Description</th>
                  <th>Amount</th>
                  <th>Category</th>
                  <th>Date</th>
                  <th>Center</th>
                </tr>
              </thead>
              <tbody></tbody>
            </table>
          </div>
        </div>

        <div class="card-lite p-3 mt-2 d-none" id="expense-add-form">
          <h6 class="fw-bold mb-2">Add New Expense Entry</h6>
          <div class="alert alert-info py-2 px-3 mb-2">Expense will be deducted from selected center's total income only.</div>
          <div class="row g-2">
            <div class="col-sm-6 col-md-3"><input type="text" id="exp-item" class="form-control" placeholder="Item Name" required></div>
            <div class="col-sm-6 col-md-3"><input type="text" id="exp-desc" class="form-control" placeholder="Description" required></div>
            <div class="col-sm-6 col-md-3"><input type="number" id="exp-amount" class="form-control" placeholder="Amount (₹)" required></div>
            <div class="col-sm-6 col-md-3"><input type="text" id="exp-category" class="form-control" placeholder="Category" required></div>
            <div class="col-sm-6 col-md-3">
              <select id="exp-center" class="form-select" required>
                <option value="Center1">Center 1</option>
                <option value="Center2">Center 2</option>
              </select>
            </div>
          </div>
          <div class="text-end mt-3">
            <button onclick="addExpenseEntry()" class="btn btn-primary">Add Expense</button>
            <button onclick="toggleAddForm('expense')" class="btn btn-ghost">Cancel</button>
          </div>
        </div>
      </div>

    </div>
  </div>

  <script>
    // --- data model (kept from your original) ---
    let centerData = {
      "Center1": { totalIncome: 0, totalExpense: 0, netAmount: 0 },
      "Center2": { totalIncome: 0, totalExpense: 0, netAmount: 0 }
    };

    let incomeData = [
      { name: "Ravi Kumar", plan: "Beginner", received: "Yes", pending: "No", amount: 1000, date: "2025-10-01", center: "Center1" },
      { name: "Priya Sharma", plan: "Intermediate", received: "No", pending: "Yes", amount: 1500, date: "2025-10-03", center: "Center2" },
      { name: "Amit Singh", plan: "Advanced", received: "Yes", pending: "No", amount: 2000, date: "2025-10-05", center: "Center1" }
    ];

    let expenseData = [
      { item: "Shuttlecocks", desc: "Pack of 50", amount: 500, category: "Equipment", date: "2025-10-02", center: "Center1" },
      { item: "Court Rent", desc: "Monthly", amount: 1000, category: "Facility", date: "2025-10-04", center: "Center2" }
    ];

    function initializeCenterData(){
      Object.keys(centerData).forEach(c=> centerData[c] = { totalIncome:0, totalExpense:0, netAmount:0 });
      incomeData.forEach(e=>{ if(e.received==="Yes"){ centerData[e.center].totalIncome += e.amount; centerData[e.center].netAmount += e.amount; } });
      expenseData.forEach(e=>{ centerData[e.center].totalExpense += e.amount; centerData[e.center].netAmount -= e.amount; });
    }

    function getCenterTotals(centerName){
      const c=centerData[centerName] || { totalIncome:0, totalExpense:0, netAmount:0 };
      return { paid:c.totalIncome, expense:c.totalExpense, net:c.netAmount, pending:getPendingAmountForCenter(centerName) };
    }
    function getPendingAmountForCenter(centerName){
      return incomeData.filter(e=> e.center===centerName && e.pending==="Yes").reduce((s,e)=> s+e.amount, 0);
    }

    function showTab(tabId){
      document.querySelectorAll('.tab-content').forEach(el=> el.style.display='none');
      document.getElementById(tabId).style.display='block';
      document.querySelectorAll('.tab-link').forEach(b=> b.classList.remove('active'));
      document.querySelector(`.tab-link[onclick="showTab('${tabId}')"]`).classList.add('active');
      applyGlobalFilters();
    }

    function toggleDateFilter(tab){
      const type = document.getElementById(`filter-type-${tab}`).value;
      document.getElementById(`date-filter-${tab}`).style.display = type==='datewise' ? 'inline-flex' : 'none';
    }
    function applyFilter(){ applyGlobalFilters(); }

    function applyGlobalFilters(){
      const active = [...document.querySelectorAll('.tab-content')].find(el=> el.style.display!== 'none').id;
      if(active==='overview') updateSummary();
      if(active==='income') updateIncomeDisplay();
      if(active==='expense') updateExpenseDisplay();
    }

    function getFilteredData(data, tab){
      let filtered = [...data];
      const month = document.getElementById('date-filter').value;
      const center = document.getElementById('center-filter').value;
      const searchTerm = document.getElementById('search').value.toLowerCase().trim();

      if(month) filtered = filtered.filter(e=> e.date.startsWith(month));
      if(center) filtered = filtered.filter(e=> e.center===center);
      if(searchTerm){
        filtered = filtered.filter(e=> Object.values(e).some(v=> String(v).toLowerCase().includes(searchTerm)));
      }

      const ft = document.getElementById(`filter-type-${tab}`)?.value;
      if(ft==='datewise'){
        const from = document.getElementById(`date-from-${tab}`)?.value;
        const to = document.getElementById(`date-to-${tab}`)?.value;
        if(from && to){
          filtered = filtered.filter(e=>{ const d=new Date(e.date); return d>=new Date(from) && d<=new Date(to); });
        }
      }
      return filtered;
    }

    function toggleAddForm(tab){
      const el = document.getElementById(`${tab}-add-form`);
      el.classList.toggle('d-none');
    }

    function addIncomeEntry(){
      const name = document.getElementById('inc-name').value.trim();
      const plan = document.getElementById('inc-plan').value.trim();
      const amount = parseFloat(document.getElementById('inc-amount').value);
      const status = document.getElementById('inc-status').value;
      const center = document.getElementById('inc-center').value;
      const date = new Date().toISOString().split('T')[0];
      if(!name || !plan || isNaN(amount) || !center){ alert('Please fill all required fields'); return; }
      const newEntry = { name, plan, received: status==='received'?'Yes':'No', pending: status==='pending'?'Yes':'No', amount, date, center };
      incomeData.push(newEntry);
      if(status==='received'){ centerData[center].totalIncome += amount; centerData[center].netAmount += amount; }
      alert(`✅ ${status==='received'?'Income':'Pending payment'} ₹${amount.toLocaleString()} added to ${center}`);
      applyGlobalFilters();
      ['inc-name','inc-plan','inc-amount'].forEach(id=> document.getElementById(id).value='');
    }

    function addExpenseEntry(){
      const item = document.getElementById('exp-item').value.trim();
      const desc = document.getElementById('exp-desc').value.trim();
      const amount = parseFloat(document.getElementById('exp-amount').value);
      const category = document.getElementById('exp-category').value.trim();
      const center = document.getElementById('exp-center').value;
      const date = new Date().toISOString().split('T')[0];
      if(!item || !desc || isNaN(amount) || !category || !center){ alert('Please fill all required fields'); return; }
      const totals = getCenterTotals(center);
      if(amount > totals.paid){ alert(`❌ Insufficient funds in ${center}!\nAvailable: ₹${totals.paid.toLocaleString()}\nRequired: ₹${amount.toLocaleString()}`); return; }
      const newEntry = { item, desc, amount, category, date, center };
      expenseData.push(newEntry);
      centerData[center].totalExpense += amount; centerData[center].netAmount -= amount;
      alert(`✅ Expense ₹${amount.toLocaleString()} deducted from ${center}\nRemaining balance: ₹${centerData[center].netAmount.toLocaleString()}`);
      applyGlobalFilters();
      ['exp-item','exp-desc','exp-amount','exp-category'].forEach(id=> document.getElementById(id).value='');
    }

    function updateIncomeDisplay(){
      const filtered = getFilteredData(incomeData,'income');
      const tbody = document.querySelector('#income-table tbody');
      tbody.innerHTML='';
      let total=0, pending=0;
      filtered.forEach(e=>{
        tbody.insertAdjacentHTML('beforeend', `
          <tr>
            <td>${e.name}</td>
            <td>${e.plan}</td>
            <td><span class="badge ${e.received==='Yes'?'text-bg-success':'text-bg-warning'}">${e.received}</span></td>
            <td><strong class="text-success">₹${e.amount.toLocaleString()}</strong></td>
            <td>${e.date}</td>
            <td><span class="badge ${e.center==='Center1'?'text-bg-primary':'text-bg-warning'}">${e.center}</span></td>
          </tr>`);
        total += e.amount; if(e.pending==='Yes') pending += e.amount;
      });
      document.getElementById('income-total').textContent = `₹${total.toLocaleString()}`;
      document.getElementById('income-pending').textContent = `₹${pending.toLocaleString()}`;
    }

    function updateExpenseDisplay(){
      const filtered = getFilteredData(expenseData,'expense');
      const tbody = document.querySelector('#expense-table tbody');
      tbody.innerHTML='';
      let total=0;
      filtered.forEach(e=>{
        tbody.insertAdjacentHTML('beforeend', `
          <tr>
            <td>${e.item}</td>
            <td>${e.desc}</td>
            <td><strong class="text-danger">₹${e.amount.toLocaleString()}</strong></td>
            <td><span class="badge text-bg-secondary">${e.category}</span></td>
            <td>${e.date}</td>
            <td><span class="badge ${e.center==='Center1'?'text-bg-primary':'text-bg-warning'}">${e.center}</span></td>
          </tr>`);
        total += e.amount;
      });
      document.getElementById('expense-total').textContent = `₹${total.toLocaleString()}`;
    }

    function updateSummary(){
      const selectedCenter = document.getElementById('center-filter').value;
      let paid, pending, expense; let label='';
      if(selectedCenter){
        const t = getCenterTotals(selectedCenter);
        paid=t.paid; pending=t.pending; expense=t.expense; label = ` - ${selectedCenter}`;
      } else {
        paid = incomeData.filter(e=>e.received==='Yes').reduce((s,e)=> s+e.amount,0);
        pending = incomeData.filter(e=>e.pending==='Yes').reduce((s,e)=> s+e.amount,0);
        expense = expenseData.reduce((s,e)=> s+e.amount,0);
      }
      document.getElementById('paid-amount').innerHTML = `<strong>₹${paid.toLocaleString()}</strong>`;
      document.getElementById('pending-amount').innerHTML = `<strong>₹${pending.toLocaleString()}</strong>`;
      document.getElementById('expense-amount').innerHTML = `<strong>₹${expense.toLocaleString()}</strong>`;
      document.getElementById('income-title').textContent = `Income Summary${label}`;
      document.getElementById('expense-title').textContent = `Expense Summary${label}`;
    }

    // init
    initializeCenterData();
    showTab('overview');
    updateSummary();

    // reactive filters
    ['date-filter','center-filter','search'].forEach(id=> document.getElementById(id).addEventListener('input', applyGlobalFilters));
  </script>

  <!-- Sidebar controller (reuse from suite) -->
  <script>
  (function () {
    const SIDEBAR_SELECTORS = '.sidebar, #sidebar, .main-sidebar';
    const TOGGLE_SELECTORS = '#sidebarToggle, .sidebar-toggle, [data-sidebar-toggle]';
    const WRAPPER_IDS = ['financeWrap','dashboardWrapper'];
    const DESKTOP_WIDTH_CUTOFF = 576;
    const SIDEBAR_OPEN_CLASS = 'active';
    const SIDEBAR_MIN_CLASS = 'minimized';
    const BODY_OVERLAY_CLASS = 'sidebar-open';
    const CSS_VAR = '--sidebar-width';
    const SIDEBAR_WIDTH_OPEN = '250px';
    const SIDEBAR_WIDTH_MIN = '60px';

    const qs = s => document.querySelector(s);
    const qsa = s => Array.from(document.querySelectorAll(s));
    const sidebarEl = () => qs('#sidebar') || qs('.sidebar') || qs('.main-sidebar');
    const wrapperEl = () => WRAPPER_IDS.map(id => document.getElementById(id)).find(Boolean) || qs('.dashboard-wrapper');
    const isMobile = () => window.innerWidth <= DESKTOP_WIDTH_CUTOFF;

    let backdrop = qs('.sidebar-backdrop');
    if (!backdrop) {
      backdrop = document.createElement('div');
      backdrop.className = 'sidebar-backdrop';
      Object.assign(backdrop.style,{position:'fixed',inset:'0',background:'rgba(0,0,0,0.42)',zIndex:'1070',display:'none',opacity:'0',transition:'opacity .18s ease'});
      document.body.appendChild(backdrop);
    }

    let lock=false; const lockFor=(ms=320)=>{ lock=true; clearTimeout(lock._t); lock._t=setTimeout(()=>lock=false,ms); };
    let lastInteractionAt=0; const INTERACTION_GAP=700;

    function openMobileSidebar(){ const s=sidebarEl(); if(!s)return; s.classList.add(SIDEBAR_OPEN_CLASS); document.body.classList.add(BODY_OVERLAY_CLASS); document.body.style.overflow='hidden'; backdrop.style.display='block'; requestAnimationFrame(()=>backdrop.style.opacity='1'); }
    function closeMobileSidebar(){ const s=sidebarEl(); if(s) s.classList.remove(SIDEBAR_OPEN_CLASS); document.body.classList.remove(BODY_OVERLAY_CLASS); document.body.style.overflow=''; backdrop.style.opacity='0'; setTimeout(()=>{ if(!document.body.classList.contains(BODY_OVERLAY_CLASS)) backdrop.style.display='none'; },220); }
    function toggleDesktopSidebar(){ const s=sidebarEl(); if(!s)return; const isMin=s.classList.toggle(SIDEBAR_MIN_CLASS); const w=wrapperEl(); if(w) w.classList.toggle('minimized',isMin); const nav=qs('.navbar'); if(nav) nav.classList.toggle('sidebar-minimized',isMin); document.documentElement.style.setProperty(CSS_VAR, isMin?SIDEBAR_WIDTH_MIN:SIDEBAR_WIDTH_OPEN); document.dispatchEvent(new CustomEvent('sidebarToggle',{detail:{minimized:isMin}})); setTimeout(()=>window.dispatchEvent(new Event('resize')),220); }
    function handleToggleEvent(e){ if(e&&e.type==='click'&&(Date.now()-lastInteractionAt) < INTERACTION_GAP) return; if(lock) return; if(isMobile()){ lockFor(260); document.body.classList.contains(BODY_OVERLAY_CLASS)?closeMobileSidebar():openMobileSidebar(); } else { lockFor(260); toggleDesktopSidebar(); } }
    function wireToggleButtons(){ qsa(TOGGLE_SELECTORS).forEach(el=>{ if(el.__sidebarToggleBound) return; el.__sidebarToggleBound=true; el.addEventListener('pointerdown',ev=>{ lastInteractionAt=Date.now(); handleToggleEvent(ev); },{passive:true}); el.addEventListener('click',ev=>{ lastInteractionAt=Date.now(); handleToggleEvent(ev); }); }); }

    document.addEventListener('pointerdown', function (ev) { if(ev.pointerType==='touch'||ev.pointerType==='pen'){ const t=ev.target.closest&&ev.target.closest(TOGGLE_SELECTORS); if(t){ lastInteractionAt=Date.now(); handleToggleEvent(ev); } } }, {passive:true});
    document.addEventListener('click', function (ev) { const t=ev.target.closest&&ev.target.closest(TOGGLE_SELECTORS); if(t) handleToggleEvent(ev); });
    backdrop.addEventListener('click', function(){ if (document.body.classList.contains(BODY_OVERLAY_CLASS)) closeMobileSidebar(); });
    document.addEventListener('click', function(e){ if(!isMobile()) return; const inside=e.target.closest&&e.target.closest(SIDEBAR_SELECTORS); if(!inside) return; const a=e.target.closest&&e.target.closest('a'); if(a&&a.getAttribute('href')&&a.getAttribute('href')!=='#'){ setTimeout(closeMobileSidebar,160); } });
    document.addEventListener('keydown', function(ev){ if(ev.key==='Escape' && document.body.classList.contains(BODY_OVERLAY_CLASS)) closeMobileSidebar(); });

    let resizeTimer=null; window.addEventListener('resize', function(){ clearTimeout(resizeTimer); resizeTimer=setTimeout(function(){ if(!isMobile()){ closeMobileSidebar(); const s=sidebarEl(); const isMin=s && s.classList.contains('minimized'); document.documentElement.style.setProperty(CSS_VAR, isMin?'60px':'250px'); } },120); });

    if(document.body.classList.contains(BODY_OVERLAY_CLASS)){ backdrop.style.display='block'; backdrop.style.opacity='1'; document.body.style.overflow='hidden'; }

    (function ensureFallbackToggle(){ const qsN=s=>document.querySelector(s); if(qsN(TOGGLE_SELECTORS)){ wireToggleButtons(); return; } const navbar=qsN('.navbar, header, .main-header, .topbar'); if(!navbar) return; const btn=document.createElement('button'); btn.type='button'; btn.id='sidebarToggle'; btn.className='btn btn-sm btn-light sidebar-toggle'; btn.setAttribute('aria-label','Toggle sidebar'); btn.style.marginRight='8px'; btn.innerHTML='<svg width="18" height="18" viewBox="0 0 24 24" aria-hidden="true"><path d="M4 6H20M4 12H20M4 18H20" stroke="#111" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>'; navbar.prepend(btn); wireToggleButtons(); })();

    document.addEventListener('DOMContentLoaded', wireToggleButtons);
  })();
  </script>
</body>
</html>
