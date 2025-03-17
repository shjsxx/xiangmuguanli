import { createRouter, createWebHistory } from 'vue-router';
import Dashboard from '../components/Dashboard.vue';
import ProjectList from '../components/ProjectList.vue';
import ProjectDetail from '../components/ProjectDetail.vue';
import ProjectForm from '../components/ProjectForm.vue';
import TaskList from '../components/TaskList.vue';
import TaskForm from '../components/TaskForm.vue';

const routes = [
  { path: '/', name: 'Dashboard', component: Dashboard },
  { path: '/projects', name: 'ProjectList', component: ProjectList },
  { path: '/projects/create', name: 'ProjectCreate', component: ProjectForm },
  { path: '/projects/:id', name: 'ProjectDetail', component: ProjectDetail },
  { path: '/projects/:id/edit', name: 'ProjectEdit', component: ProjectForm },
  { path: '/tasks', name: 'TaskList', component: TaskList },
  { path: '/tasks/create', name: 'TaskCreate', component: TaskForm },
  { path: '/tasks/:id/edit', name: 'TaskEdit', component: TaskForm },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;