// Login fake (solo visual). Usuario: admin, Pass: admin
const AUTH_KEY = "demo_auth";

function isAuthed(){
  return localStorage.getItem(AUTH_KEY) === "1";
}

function requireAuth(){
  if(!isAuthed()) location.href = "login.html";
}

function login(username, password){
  if(username === "admin" && password === "admin"){
    localStorage.setItem(AUTH_KEY, "1");
    location.href = "dashboard.html";
  }else{
    alert("Credenciales incorrectas (usa admin/admin)");
  }
}

function logout(){
  localStorage.removeItem(AUTH_KEY);
  location.href = "login.html";
}

// Data storage (sin BD)
function getStore(key, fallback){
  try { return JSON.parse(localStorage.getItem(key)) ?? fallback; }
  catch { return fallback; }
}
function setStore(key, value){
  localStorage.setItem(key, JSON.stringify(value));
}

const K_PROJECTS = "demo_projects";
const K_SKILLS = "demo_skills";
const K_XP = "demo_xp";

function seedIfEmpty(){
  if(!localStorage.getItem(K_PROJECTS)){
    setStore(K_PROJECTS, [
      {id: crypto.randomUUID(), title:"ProductApp", tech:"HTML,JS", status:"Publicado"},
      {id: crypto.randomUUID(), title:"Sistema Calificaciones", tech:"PHP,Bootstrap", status:"Borrador"},
    ]);
  }
  if(!localStorage.getItem(K_SKILLS)){
    setStore(K_SKILLS, [
      {id: crypto.randomUUID(), name:"JavaScript", level:"Medio", category:"Frontend"},
      {id: crypto.randomUUID(), name:"MySQL", level:"Básico", category:"Base de Datos"},
    ]);
  }
  if(!localStorage.getItem(K_XP)){
    setStore(K_XP, [
      {id: crypto.randomUUID(), company:"BUAP", role:"Desarrollador/a", from:"2025", to:"Actual"}
    ]);
  }
}
seedIfEmpty();
