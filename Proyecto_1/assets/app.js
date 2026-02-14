// Datos demo para la vista pública (sin BD)
const demoData = {
  profile: {
    name: "Tu Nombre",
    role: "Estudiante de Contaduría e Ing. TI",
    bio: "Portafolio en construcción: proyectos, habilidades y experiencia. Aquí irá tu historia corta.",
    email: "tu-correo@ejemplo.com",
    github: "https://github.com/",
    linkedin: "https://linkedin.com/"
  },
  projects: [
    { id: 1, title: "ProductApp", desc: "Catálogo tipo e-commerce con admin y estadísticas.", tech: ["HTML","JS","MySQL"], repo:"#", demo:"#", featured:true },
    { id: 2, title: "Sistema de Calificaciones", desc: "Gestión de calificaciones y asistencias por semestre.", tech: ["PHP","Bootstrap"], repo:"#", demo:"#", featured:true },
    { id: 3, title: "Inventario Tienda", desc: "Control de stock, categorías y proveedores.", tech: ["CRUD","Capas"], repo:"#", demo:"#", featured:false },
  ],
  skills: [
    { name:"HTML/CSS", level:80, cat:"Frontend" },
    { name:"JavaScript", level:70, cat:"Frontend" },
    { name:"PHP", level:65, cat:"Backend" },
    { name:"MySQL", level:60, cat:"Base de Datos" },
    { name:"Git/GitHub", level:70, cat:"Tools" }
  ],
  experience: [
    { company:"BUAP (Proyecto escolar)", role:"Desarrollador/a", from:"2025", to:"Actual", points:["CRUD", "Capas", "Documentación"] }
  ]
};

function renderFeaturedProjects() {
  const wrap = document.querySelector("#featuredProjects");
  if(!wrap) return;
  wrap.innerHTML = "";

  const featured = demoData.projects.filter(p=>p.featured);
  featured.forEach(p=>{
    const techBadges = p.tech.map(t=>`<span class="badge rounded-pill badge-tech me-1">${t}</span>`).join("");
    wrap.insertAdjacentHTML("beforeend", `
      <div class="col-md-6 col-lg-4">
        <div class="card card-glass h-100 p-3">
          <div class="d-flex align-items-start justify-content-between">
            <h5 class="mb-1">${p.title}</h5>
            <span class="badge text-bg-success">Destacado</span>
          </div>
          <p class="muted mb-2">${p.desc}</p>
          <div class="mb-3">${techBadges}</div>
          <div class="mt-auto d-flex gap-2">
            <a class="btn btn-sm btn-soft" href="project.html?id=${p.id}">Ver detalle</a>
            <a class="btn btn-sm btn-outline-light" href="${p.repo}">Repo</a>
          </div>
        </div>
      </div>
    `);
  });
}

function renderSkills() {
  const wrap = document.querySelector("#skillsWrap");
  if(!wrap) return;
  wrap.innerHTML = "";
  const byCat = demoData.skills.reduce((acc,s)=>{
    acc[s.cat] ??= [];
    acc[s.cat].push(s);
    return acc;
  },{});

  Object.entries(byCat).forEach(([cat, items])=>{
    const rows = items.map(s=>`
      <div class="mb-3">
        <div class="d-flex justify-content-between">
          <span>${s.name}</span>
          <span class="muted">${s.level}%</span>
        </div>
        <div class="progress" style="height:10px;background:rgba(255,255,255,.10)">
          <div class="progress-bar" role="progressbar" style="width:${s.level}%"></div>
        </div>
      </div>
    `).join("");
    wrap.insertAdjacentHTML("beforeend", `
      <div class="col-md-6">
        <div class="card card-glass p-3 h-100">
          <h6 class="mb-3">${cat}</h6>
          ${rows}
        </div>
      </div>
    `);
  });
}

function renderExperience() {
  const wrap = document.querySelector("#xpWrap");
  if(!wrap) return;
  wrap.innerHTML = "";

  demoData.experience.forEach(x=>{
    const pts = x.points.map(p=>`<li class="muted">${p}</li>`).join("");
    wrap.insertAdjacentHTML("beforeend", `
      <div class="card card-glass p-3 mb-3">
        <div class="d-flex justify-content-between flex-wrap gap-2">
          <div>
            <h6 class="mb-1">${x.role}</h6>
            <div class="muted">${x.company}</div>
          </div>
          <div class="muted">${x.from} - ${x.to}</div>
        </div>
        <div class="divider"></div>
        <ul class="mb-0">${pts}</ul>
      </div>
    `);
  });
}

function fillProfile() {
  const p = demoData.profile;
  const name = document.querySelector("#pName");
  const role = document.querySelector("#pRole");
  const bio  = document.querySelector("#pBio");
  const email= document.querySelector("#pEmail");
  const gh   = document.querySelector("#pGitHub");
  const li   = document.querySelector("#pLinkedIn");

  if(name) name.textContent = p.name;
  if(role) role.textContent = p.role;
  if(bio)  bio.textContent  = p.bio;
  if(email) email.textContent = p.email;
  if(gh) gh.href = p.github;
  if(li) li.href = p.linkedin;
}

document.addEventListener("DOMContentLoaded", ()=>{
  fillProfile();
  renderFeaturedProjects();
  renderSkills();
  renderExperience();
});
