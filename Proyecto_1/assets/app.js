const data = {
  profile: {
    name: "Tu Nombre Aquí",
    role: "Estudiante de Contaduría e Ingeniería en TI",
    bio: "Soy estudiante con enfoque en desarrollo web, bases de datos y arquitectura en capas.",
    email: "tuemail@gmail.com",
    github: "https://github.com/",
    linkedin: "https://linkedin.com/"
  },

  projects: [
    {
      title: "Sistema de Gestión de Inventario",
      description: "Aplicación CRUD para controlar productos, categorías y stock.",
      technologies: ["HTML", "Bootstrap", "JavaScript"]
    },
    {
      title: "Sistema de Calificaciones BUAP",
      description: "Sistema para docentes que gestiona asistencias y calificaciones por semestre.",
      technologies: ["PHP", "MySQL"]
    }
  ],

  skills: [
    { name: "HTML/CSS", level: 80 },
    { name: "JavaScript", level: 70 },
    { name: "MySQL", level: 65 }
  ],

  experience: [
    {
      role: "Desarrollador/a Web",
      company: "Proyecto Escolar",
      period: "2025 - Actualidad"
    }
  ]
};

document.addEventListener("DOMContentLoaded", () => {

  // Perfil (si existe el elemento, lo llena)
  const pName = document.getElementById("pName");
  const pRole = document.getElementById("pRole");
  const pBio  = document.getElementById("pBio");
  const pEmail= document.getElementById("pEmail");
  const pGit  = document.getElementById("pGitHub");
  const pLin  = document.getElementById("pLinkedIn");

  if(pName) pName.textContent = data.profile.name;
  if(pRole) pRole.textContent = data.profile.role;
  if(pBio)  pBio.textContent  = data.profile.bio;
  if(pEmail) pEmail.textContent = data.profile.email;
  if(pGit) pGit.href = data.profile.github;
  if(pLin) pLin.href = data.profile.linkedin;

  // Proyectos
  const projectsWrap = document.getElementById("projectsWrap");
  if(projectsWrap){
    projectsWrap.innerHTML = "";
    data.projects.forEach(p => {
      projectsWrap.innerHTML += `
        <div class="col-md-6">
          <div class="card card-glass p-3 h-100">
            <h5 class="mb-2">${p.title}</h5>
            <p class="muted">${p.description}</p>
            <div class="mt-2">
              ${p.technologies.map(t => `<span class="badge me-1">${t}</span>`).join("")}
            </div>
          </div>
        </div>
      `;
    });
  }

  // Habilidades
  const skillsWrap = document.getElementById("skillsWrap");
  if(skillsWrap){
    skillsWrap.innerHTML = "";
    data.skills.forEach(s => {
      skillsWrap.innerHTML += `
        <div class="col-md-6">
          <div class="card card-glass p-3">
            <div class="d-flex justify-content-between">
              <span>${s.name}</span>
              <span class="muted">${s.level}%</span>
            </div>
            <div class="progress mt-2" style="height:10px;">
              <div class="progress-bar" style="width:${s.level}%"></div>
            </div>
          </div>
        </div>
      `;
    });
  }

  // Experiencia
  const experienceWrap = document.getElementById("experienceWrap");
  if(experienceWrap){
    experienceWrap.innerHTML = "";
    data.experience.forEach(e => {
      experienceWrap.innerHTML += `
        <div class="card card-glass p-3 mb-3">
          <h5 class="mb-1">${e.role}</h5>
          <div class="muted">${e.company}</div>
          <div class="muted">${e.period}</div>
        </div>
      `;
    });
  }

});
