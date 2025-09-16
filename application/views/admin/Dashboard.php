<!-- application/views/admin/Dashboard.php -->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Dashboard</title>
    <link rel="icon" type="image/jpg" sizes="32x32" href="<?php echo base_url('assets\Images\timeersbadmintonacademy_logo.jpg'); ?>">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet"/>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&display=swap" rel="stylesheet"/>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/xlsx@0.18.5/dist/xlsx.full.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/jspdf@2.5.1/dist/jspdf.umd.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.8.3/jspdf.plugin.autotable.min.js"></script>
  <style>
    body{font-family:'Montserrat',sans-serif;background:#e9ecef;color:#fff;overflow-x:hidden}
    .dashboard{margin-left:250px;padding:18px;min-height:100vh;transition:.25s}
    .card-stat{border-radius:12px;padding:18px;color:#fff;cursor:pointer;display:flex;justify-content:space-between;align-items:center}
    .card-stat h3{margin:0;font-weight:700}
    .card-stat p{margin:0;font-size:13px;opacity:.95}
    .stat-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:15px;margin-bottom:18px}
    .btn-custom{background:#000;color:#fff;border:none;padding:8px 14px;border-radius:6px;font-weight:600}
    .table-card, .chart-card, .attendance-card{background:#fff;color:#000;border-radius:12px;padding:16px;box-shadow:0 6px 18px rgba(0,0,0,.06)}
    .students-table{width:100%;min-width:680px;font-size:13px}
    .students-table th{background:#333;color:#fff;position:sticky;top:0}
    .status-badge{padding:4px 8px;border-radius:10px;font-weight:700;font-size:11px}
    .status-complete{background:#d4edda;color:#155724}
    .status-pending{background:#f8d7da;color:#721c24}
    @media(max-width:992px){.stat-grid{grid-template-columns:repeat(2,1fr)}.dashboard{margin-left:0}}

    /* New styles for scrollable students list and search */
    .students-table-container { max-height: 360px; overflow:auto; background:#fff; border-radius:8px; padding:8px; }
    .students-table thead th { position: sticky; top: 0; background:#333; color:#fff; z-index: 2; }
    .loading-row { text-align:center; padding:18px; color:#666; }
    .search-controls .input-group .form-control { height:36px; }
    .students-info { font-size:13px; color:#666; }
  </style>
</head>
<body>
  <!-- Sidebar & Navbar (kept as original includes) -->
  <?php $this->load->view('admin/Include/Sidebar') ?>
  <?php $this->load->view('admin/Include/Navbar') ?>

  <div class="dashboard" id="dashboard">
    <div class="container-fluid">
      <!-- Stats -->
      <div class="stat-grid">
        <div class="card-stat" style="background:linear-gradient(90deg,#ff4040,#470000)" onclick="handleStat('total')">
          <div>
            <h3 id="totalCount">2450</h3>
            <p>Total Students</p>
          </div>
          <i class="bi bi-people-fill fs-3 opacity-50"></i>
        </div>
        <div class="card-stat" style="background:linear-gradient(90deg,#ff6b6b,#8b0000)" onclick="handleStat('active')">
          <div>
            <h3 id="activeCount">1800</h3>
            <p>Active Students</p>
          </div>
          <i class="bi bi-person-check fs-3 opacity-50"></i>
        </div>
        <div class="card-stat" style="background:linear-gradient(90deg,#ff9a9a,#330000)" onclick="handleStat('deactive')">
          <div>
            <h3 id="deactiveCount">650</h3>
            <p>Deactive Students</p>
          </div>
          <i class="bi bi-person-x fs-3 opacity-50"></i>
        </div>
        <div class="card-stat" style="background:linear-gradient(90deg,#ff4040,#470000);flex-direction:column;justify-content:center" onclick="handleStat('center')">
          <div style="text-align:left;width:100%">
            <h6 style="font-size:13px;margin-bottom:6px;opacity:.9">Center</h6>
            <h4 id="centerName" style="margin:0;font-weight:800">Downtown Academy</h4>
          </div>
        </div>
      </div>

      <!-- Export buttons -->
      <div class="d-flex gap-2 flex-wrap mb-3">
        <button class="btn-custom" onclick="exportToExcel()"><i class="bi bi-download me-1"></i> Excel</button>
        <button class="btn-custom" onclick="exportToPDF()"><i class="bi bi-file-earmark-pdf me-1"></i> PDF</button>
      </div>

      <!-- Main grid -->
      <div class="row g-3">
        <div class="col-12">
          <div class="table-card">
            <div class="d-flex justify-content-between align-items-center mb-2">
              <h6 class="mb-0">Recently Added Students</h6>
              <div>
                <button class="btn btn-sm btn-dark me-2" data-bs-toggle="modal" data-bs-target="#studentsFilterModal"><i class="bi bi-funnel"></i> Filter</button>
                <button class="btn btn-sm" style="background:#ff4040;color:#fff" data-bs-toggle="modal" data-bs-target="#addStudentModal"><i class="fas fa-plus"></i> Add</button>
              </div>
            </div>

            <!-- Search + info + load more -->
            <div class="d-flex align-items-center justify-content-between mb-2 search-controls">
              <div class="input-group w-50">
                <input id="studentSearch" class="form-control form-control-sm" placeholder="Search by name or contact..." aria-label="Search students">
                <button id="studentSearchBtn" class="btn btn-sm btn-dark" type="button"><i class="bi bi-search"></i></button>
                <button id="studentClearBtn" class="btn btn-sm btn-secondary" type="button">Clear</button>
              </div>
              <div class="d-flex align-items-center gap-2">
                <small id="studentsInfo" class="students-info">Loading…</small>
                <button id="loadMoreBtn" class="btn btn-sm btn-outline-primary">Load more</button>
              </div>
            </div>

            <!-- Scrollable students table -->
            <div class="students-table-container">
              <table class="table students-table table-striped mb-0">
                <thead>
                  <tr>
                    <th>Name</th><th>Contact</th><th>Center</th><th>Batch</th><th>Level</th><th>Category</th><th>Action</th>
                  </tr>
                </thead>
                <tbody id="studentsTableBody">
                  <!-- initial fallback (will be replaced by AJAX) -->
                  <tr><td colspan="7" class="loading-row">Loading students…</td></tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>

        <div class="col-lg-6">
          <div class="attendance-card">
            <div class="d-flex justify-content-between align-items-center mb-2">
              <h6 class="mb-0">Student Attendance</h6>
              <button class="btn btn-sm btn-dark" data-bs-toggle="modal" data-bs-target="#attendanceFilterModal"><i class="bi bi-funnel"></i> Filter</button>
            </div>
            <div class="table-responsive">
              <table class="table table-striped" id="attendanceTable">
                <thead><tr><th>Name</th><th>Batch</th><th>Level</th><th>Status</th><th>Action</th></tr></thead>
                <tbody id="attendanceTableBody"></tbody>
              </table>
            </div>
          </div>
        </div>

        <div class="col-lg-6">
          <div class="chart-card">
            <div class="chart-card p-0">
              <h6 class="mb-2">Total Students</h6>
              <canvas id="studentChart" style="max-height:200px"></canvas>
              <div class="mt-2">
                <small><span class="me-3"><i class="bi bi-square-fill" style="color:#ff6b6b"></i> Beginner (30%)</span>
                <span class="me-3"><i class="bi bi-square-fill" style="color:#ffeb3b"></i> Intermediate (40%)</span>
                <span><i class="bi bi-square-fill" style="color:#4ecdc4"></i> Advanced (30%)</span></small>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Modals: Add / Edit / View / Filters (kept minimal) -->
    <div class="modal fade" id="addStudentModal" tabindex="-1"><div class="modal-dialog modal-dialog-centered"><div class="modal-content p-3">
      <div class="d-flex justify-content-between"><h5>Add Student</h5><button class="btn-close" data-bs-dismiss="modal"></button></div>
      <form id="addStudentForm" class="mt-2">
        <input class="form-control mb-2" id="addStudentName" placeholder="Name" required pattern="[A-Za-z\s]+">
        <input class="form-control mb-2" id="addStudentContact" placeholder="Contact" required pattern="[0-9]{10}">
        <select id="addStudentCenter" class="form-control mb-2" required><option value="">-- Select Center --</option></select>
        <select id="addStudentBatch" class="form-control mb-2" required><option value="">-- Select Batch --</option></select>
        <select id="addStudentLevel" class="form-control mb-2" required><option value="">Level</option><option>Beginner</option><option>Intermediate</option><option>Advanced</option></select>
        <select id="addStudentCategory" class="form-control mb-2" required><option value="">Category</option><option>Complete</option><option>Pending</option></select>
        <div class="d-flex justify-content-center"><button class="btn btn-light me-2" type="submit">Add</button><button class="btn btn-secondary" data-bs-dismiss="modal" type="button">Cancel</button></div>
      </form>
    </div></div></div>

    <div class="modal fade" id="editStudentModal" tabindex="-1"><div class="modal-dialog modal-dialog-centered"><div class="modal-content p-3">
      <div class="d-flex justify-content-between"><h5>Edit Student</h5><button class="btn-close" data-bs-dismiss="modal"></button></div>
      <form id="editStudentForm" class="mt-2">
        <input type="hidden" id="editStudentId">
        <input class="form-control mb-2" id="editStudentName" placeholder="Name" required pattern="[A-Za-z\s]+">
        <input class="form-control mb-2" id="editStudentContact" placeholder="Contact" required pattern="[0-9]{10}">
        <input class="form-control mb-2" id="editStudentCenter" placeholder="Center" required>
        <input class="form-control mb-2" id="editStudentBatch" placeholder="Batch" required>
        <select id="editStudentLevel" class="form-control mb-2" required><option value="">Level</option><option>Beginner</option><option>Intermediate</option><option>Advanced</option></select>
        <select id="editStudentCategory" class="form-control mb-2" required><option value="">Category</option><option>Complete</option><option>Pending</option></select>
        <div class="d-flex justify-content-center"><button class="btn btn-light me-2" type="submit">Save</button><button class="btn btn-secondary" data-bs-dismiss="modal" type="button">Cancel</button></div>
      </form>
    </div></div></div>

    <div class="modal fade" id="viewStudentModal" tabindex="-1"><div class="modal-dialog modal-dialog-centered"><div class="modal-content p-3">
      <div class="d-flex justify-content-between"><h5>Student Details</h5><button class="btn-close" data-bs-dismiss="modal"></button></div>
      <div id="viewStudentContent" class="mt-2"></div>
    </div></div></div>

    <!-- Simple filter modals -->
    <div class="modal fade" id="studentsFilterModal" tabindex="-1"><div class="modal-dialog modal-dialog-centered"><div class="modal-content p-3">
      <div class="d-flex justify-content-between"><h5>Filter Students</h5><button class="btn-close" data-bs-dismiss="modal"></button></div>
      <form id="studentsFilterForm" class="mt-2">
        <input class="form-control mb-2" id="filterStudentName" placeholder="Name">
        <input class="form-control mb-2" id="filterStudentContact" placeholder="Contact">
        <div class="d-flex justify-content-center"><button class="btn btn-light me-2" type="submit">Apply</button><button class="btn btn-secondary" data-bs-dismiss="modal" type="button">Cancel</button></div>
      </form>
    </div></div></div>

    <div class="modal fade" id="attendanceFilterModal" tabindex="-1"><div class="modal-dialog modal-dialog-centered"><div class="modal-content p-3">
      <div class="d-flex justify-content-between"><h5>Filter Attendance</h5><button class="btn-close" data-bs-dismiss="modal"></button></div>
      <form id="attendanceFilterForm" class="mt-2">
        <input class="form-control mb-2" id="filterAttendanceName" placeholder="Name">
        <div class="d-flex justify-content-center"><button class="btn btn-light me-2" type="submit">Apply</button><button class="btn btn-secondary" data-bs-dismiss="modal" type="button">Cancel</button></div>
      </form>
    </div></div></div>

  </div> <!-- /dashboard -->

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

  <script>
    // ---------- existing minimal data & functions (trimmed) ----------
    const studentData = {
      jane:{name:'Jane Doe',contact:'9876543210',center:'ABC',batch:'B1',level:'Intermediate',category:'Complete'},
      john:{name:'John Smith',contact:'9876543211',center:'XYZ',batch:'B2',level:'Advanced',category:'Pending'},
      sarah:{name:'Sarah Wilson',contact:'9876543212',center:'PQR',batch:'B3',level:'Beginner',category:'Complete'}
    };
    const attendanceData = {...studentData};
    function renderTables(){
      const sb=document.getElementById('studentsTableBody'); sb.innerHTML='';
      Object.entries(studentData).forEach(([id,s])=>{
        const tr=document.createElement('tr');
        tr.innerHTML=`<td>${s.name}</td><td>${s.contact}</td><td>${s.center}</td><td>${s.batch}</td><td>${s.level}</td>
          <td><span class="status-badge ${s.category==='Complete'?'status-complete':'status-pending'}">${s.category}</span></td>
          <td><div class="d-flex gap-1">
            <button class="btn btn-sm btn-outline-secondary" onclick="viewStudent('${id}')" data-bs-toggle="modal" data-bs-target="#viewStudentModal"><i class="bi bi-eye"></i></button>
            <button class="btn btn-sm btn-outline-success" onclick="editStudent('${id}')" data-bs-toggle="modal" data-bs-target="#editStudentModal"><i class="bi bi-pencil"></i></button>
            <button class="btn btn-sm btn-outline-danger" onclick="deleteStudent('${id}')"><i class="bi bi-trash"></i></button>
          </div></td>`;
        sb.appendChild(tr);
      });

      const ab=document.getElementById('attendanceTableBody'); ab.innerHTML='';
      Object.entries(attendanceData).forEach(([id,r])=>{
        const tr=document.createElement('tr');
        tr.innerHTML=`<td>${r.name}</td><td>${r.batch}</td><td>${r.level}</td><td><span class="status-badge">${r.category || 'Present'}</span></td>
          <td><button class="btn btn-sm btn-outline-secondary" onclick="viewAttendance('${id}')"><i class="bi bi-eye"></i></button></td>`;
        ab.appendChild(tr);
      });

      document.getElementById('totalCount').innerText=Object.keys(studentData).length;
      document.getElementById('activeCount').innerText=Object.keys(studentData).length - 1; // demo
      document.getElementById('deactiveCount').innerText=1; // demo
    }

    function viewStudent(id){
      const s=studentData[id];
      document.getElementById('viewStudentContent').innerHTML = s ? `<p><strong>${s.name}</strong></p><p>${s.contact}</p><p>${s.center} • ${s.batch}</p><p>${s.level} • ${s.category}</p>` : 'Not found';
    }
    function editStudent(id){
      const s=studentData[id];
      if(!s) return;
      document.getElementById('editStudentId').value=id;
      document.getElementById('editStudentName').value=s.name;
      document.getElementById('editStudentContact').value=s.contact;
      document.getElementById('editStudentCenter').value=s.center;
      document.getElementById('editStudentBatch').value=s.batch;
      document.getElementById('editStudentLevel').value=s.level;
      document.getElementById('editStudentCategory').value=s.category;
    }
    function deleteStudent(id){
      if(!studentData[id]) return;
      Swal.fire({title:`Delete ${studentData[id].name}?`,icon:'warning',showCancelButton:true,confirmButtonText:'Yes'}).then(res=>{
        if(res.isConfirmed){ delete studentData[id]; delete attendanceData[id]; renderTables(); Swal.fire({icon:'success',title:'Deleted',timer:1200,showConfirmButton:false});}
      });
    }
    function viewAttendance(id){ const r=attendanceData[id]; if(!r) return Swal.fire('Not found'); Swal.fire({title:'Attendance',html:`<p>${r.name}</p><p>${r.batch} • ${r.level}</p>`}); }

    // form handlers (demo behavior left intact)
    document.getElementById('addStudentForm').addEventListener('submit',function(e){
      e.preventDefault();
      const name=document.getElementById('addStudentName').value.trim(); if(!name) return;
      const id=name.toLowerCase().replace(/\s+/g,''); studentData[id]={name,contact:document.getElementById('addStudentContact').value||'',center:document.getElementById('addStudentCenter').value||'Local',batch:document.getElementById('addStudentBatch').value||'B1',level:document.getElementById('addStudentLevel').value||'Beginner',category:document.getElementById('addStudentCategory').value||'Pending'};
      attendanceData[id]={...studentData[id]}; renderTables(); bootstrap.Modal.getInstance(document.getElementById('addStudentModal')).hide();
      Swal.fire({icon:'success',title:'Added',timer:1200,showConfirmButton:false});
    });

    document.getElementById('editStudentForm').addEventListener('submit',function(e){
      e.preventDefault();
      const id=document.getElementById('editStudentId').value; if(!id) return;
      studentData[id]={name:document.getElementById('editStudentName').value,contact:document.getElementById('editStudentContact').value,center:document.getElementById('editStudentCenter').value,batch:document.getElementById('editStudentBatch').value,level:document.getElementById('editStudentLevel').value,category:document.getElementById('editStudentCategory').value};
      attendanceData[id]={...studentData[id]}; renderTables(); bootstrap.Modal.getInstance(document.getElementById('editStudentModal')).hide();
      Swal.fire({icon:'success',title:'Saved',timer:1200,showConfirmButton:false});
    });

    // simple helpers & exports
    function handleStat(t){ Swal.fire({icon:'info',title:`Clicked ${t}`}) }
    function exportToExcel(){ const arr=Object.values(studentData).map(s=>({Name:s.name,Contact:s.contact,Center:s.center,Batch:s.batch,Level:s.level,Category:s.category})); const ws=XLSX.utils.json_to_sheet(arr); const wb=XLSX.utils.book_new(); XLSX.utils.book_append_sheet(wb,ws,'Students'); XLSX.writeFile(wb,'students_data.xlsx'); }
    function exportToPDF(){ const { jsPDF } = window.jspdf; const doc=new jsPDF(); doc.text('Students Data',14,18); const body=Object.values(studentData).map(s=>[s.name,s.contact,s.center,s.batch,s.level,s.category]); doc.autoTable({head:[['Name','Contact','Center','Batch','Level','Category']],body,startY:24}); doc.save('students_data.pdf'); }

    // chart
    function initChart(){
      const ctx=document.getElementById('studentChart'); new Chart(ctx,{type:'doughnut',data:{labels:['Beginner','Intermediate','Advanced'],datasets:[{data:[30,40,30],backgroundColor:['#ff6b6b','#ffeb3b','#4ecdc4'],cutout:'70%'}]},options:{plugins:{legend:{display:false}}}});
    }

    // ---------- New: AJAX for center stats and paginated students ----------
    (function initDynamic() {
      // change this base if your app doesn't use /timersacademy-1/index.php/
      const BASE_STATS_URL = '/timersacademy-1/index.php/admin/get_center_stats';
      const BASE_STUDENTS_URL = '/timersacademy-1/index.php/admin/get_students_ajax';

      // fetch center stats and update UI
      function fetchCenterStats() {
        $.ajax({
          url: BASE_STATS_URL,
          method: 'GET',
          dataType: 'json'
        }).done(function(res){
          console.log('center stats:', res);
          if(res && res.success){
            $('#centerName').text(res.center_name);
            $('#totalCount').text(res.total_students);
            if(typeof res.active_students !== 'undefined') $('#activeCount').text(res.active_students);
            if(typeof res.deactive_students !== 'undefined') $('#deactiveCount').text(res.deactive_students);
          } else {
            console.warn('Could not load center stats:', res && res.message ? res.message : res);
          }
        }).fail(function(xhr){
          console.error('Request failed:', xhr.statusText);
        });
      }

      // Students pagination + search + infinite scroll
      const perPage = 10;
      let page = 1;
      let loading = false;
      let noMore = false;
      let currentSearch = '';

      const $container = $('.students-table-container');
      const $tbody = $('#studentsTableBody');
      const $info = $('#studentsInfo');
      const $loadMore = $('#loadMoreBtn');
      const $searchInp = $('#studentSearch');
      const $searchBtn = $('#studentSearchBtn');
      const $clearBtn = $('#studentClearBtn');

      function esc(t){ return $('<div/>').text(t||'').html(); }

      function renderStudents(rows, append = true){
        if(!append) $tbody.empty();
        if(rows.length === 0 && !append){
          $tbody.html('<tr><td colspan="7" class="loading-row">No students found</td></tr>');
          return;
        }
        const html = rows.map(s => {
          const category = s.category || s.status || '';
          const badgeClass = category === 'Complete' ? 'status-complete' : 'status-pending';
          return `<tr>
            <td>${esc(s.name)}</td>
            <td>${esc(s.contact)}</td>
            <td>${esc(s.center)}</td>
            <td>${esc(s.batch)}</td>
            <td>${esc(s.level)}</td>
            <td><span class="status-badge ${badgeClass}">${esc(category)}</span></td>
            <td>
              <div class="d-flex gap-1">
                <button class="btn btn-sm btn-outline-secondary" onclick="viewStudent('${s.id}')" data-bs-toggle="modal" data-bs-target="#viewStudentModal"><i class="bi bi-eye"></i></button>
                <button class="btn btn-sm btn-outline-success" onclick="editStudent('${s.id}')" data-bs-toggle="modal" data-bs-target="#editStudentModal"><i class="bi bi-pencil"></i></button>
                <button class="btn btn-sm btn-outline-danger" onclick="deleteStudent('${s.id}')"><i class="bi bi-trash"></i></button>
              </div>
            </td>
          </tr>`;
        }).join('');
        $tbody.append(html);
      }

      function fetchPage(p, opts = {append:true}){
        if(loading || noMore) return;
        loading = true;
        $info.text('Loading...');
        $loadMore.prop('disabled', true).text('Loading...');

        $.ajax({
          url: BASE_STUDENTS_URL,
          method: 'GET',
          dataType: 'json',
          data: { page: p, per_page: perPage, search: currentSearch }
        }).done(function(res){
          if(!res || !res.success){
            if(p===1) $tbody.html('<tr><td colspan="7" class="loading-row">No students found</td></tr>');
            $info.text(res && res.message ? res.message : 'Error loading');
            noMore = true;
            return;
          }
          const total = res.total || 0;
          const students = res.students || [];
          const showed = (p-1)*perPage + students.length;
          renderStudents(students, opts.append);

          // update flags
          if(showed >= total) { noMore = true; $loadMore.hide(); $info.text(`${showed} of ${total}`); }
          else { noMore = false; $loadMore.show(); $info.text(`${showed} of ${total}`); }

          if(p === 1 && students.length === 0){
            $tbody.html('<tr><td colspan="7" class="loading-row">No students found</td></tr>');
          }
        }).fail(function(){
          $info.text('Request failed');
        }).always(function(){
          loading = false;
          $loadMore.prop('disabled', false).text('Load more');
        });
      }

      function resetAndLoad(){
        page = 1; noMore = false; $tbody.empty();
        fetchPage(page, {append:true});
      }

      $loadMore.on('click', function(){
        if(noMore || loading) return;
        page += 1;
        fetchPage(page, {append:true});
      });

      $container.on('scroll', function(){
        const el = this;
        if(noMore || loading) return;
        if (el.scrollHeight - el.scrollTop - el.clientHeight < 200) {
          page += 1;
          fetchPage(page, {append:true});
        }
      });

      // search debounce
      let debounceTimer = null;
      function doSearch(q){
        currentSearch = q || '';
        page = 1; noMore = false; $tbody.empty();
        fetchPage(page, {append:true});
      }
      function debounceSearch(q){
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(()=> doSearch(q), 300);
      }

      $searchInp.on('input', function(){ debounceSearch($(this).val()); });
      $searchBtn.on('click', function(){ doSearch($searchInp.val()); });
      $clearBtn.on('click', function(){ $searchInp.val(''); doSearch(''); });

      // initial fetches
      fetchCenterStats();
      resetAndLoad();
      initChart();
      renderTables(); // keeps demo data for attendance & exports working

    })();
  </script>
</body>
</html>
