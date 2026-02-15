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
      description: "Aplicación CRUD para controlar productos y stock.",
      technologies: ["HTML", "Bootstrap", "JavaScript"]
    },
    {
      title: "Sistema de Calificaciones BUAP",
      description: "Sistema para docentes que gestiona asistencias y calificaciones.",
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

  // Perfil
  document.getElementById("pName").textContent = data.profile.name;
  document.getElementById("pRole").textContent = data.profile.role;
  document.getElementById("pBio").textContent = data.profile.bio;
  document.getElementById("pEmail").textContent = data.profile.email;
  document.getElementById("pGitHub").href = data.profile.github;
  document.getElementById("pLinkedIn").href = data.profile.linkedin;

  // Proyectos
  const projectsWrap = document.getElementById("projectsWrap");
  data.projects.forEach(p => {
    projectsWrap.innerHTML += `
      <div class="col-md-6">
        <div class="card card-glass p-3">
          <h5>${p.title}</h5>
          <p>${p.description}</p>
          <div>
            ${p.technologies.map(t => `<span class="badge bg-secondary me-1">${t}</span>`).join("")}
          </div>
        </div>
      </div>
    `;
  });

  // Habilidades
  const skillsWrap = document.getElementById("skillsWrap");
  data.skills.forEach(s => {
    skillsWrap.innerHTML += `
      <div class="col-md-6">
        <div class="card card-glass p-3">
          <div class="d-flex justify-content-between">
            <span>${s.name}</span>
            <span>${s.level}%</span>
          </div>
          <div class="progress">
            <div class="progress-bar" style="width:${s.level}%"></div>
          </div>
        </div>
      </div>
    `;
  });

  // Experiencia
  const experienceWrap = document.getElementById("experienceWrap");
  data.experience.forEach(e => {
    experienceWrap.innerHTML += `
      <div class="card card-glass p-3 mb-3">
        <h5>${e.role}</h5>
        <p>${e.company}</p>
        <small>${e.period}</small>
      </div>
    `;
  });

});
