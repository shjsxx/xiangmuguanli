<template>
  <div>
    <h2>任务列表</h2>
    <router-link to="/tasks/create" class="btn btn-primary mb-3">新建任务</router-link>
    <table class="table">
      <thead>
        <tr>
          <th>名称</th>
          <th>所属项目</th>
          <th>状态</th>
          <th>截止日期</th>
          <th>操作</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="task in tasks" :key="task.id">
          <td>{{ task.name }}</td>
          <td><router-link :to="`/projects/${task.project_id}`">{{ getProjectName(task.project_id) }}</router-link></td>
          <td>{{ task.status }}</td>
          <td>{{ task.due_date }}</td>
          <td>
            <router-link :to="`/tasks/${task.id}/edit`" class="btn btn-sm btn-warning me-2">编辑</router-link>
            <button @click="deleteTask(task.id)" class="btn btn-sm btn-danger">删除</button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import { useRouter } from 'vue-router';

const tasks = ref();
const projects = ref();
const router = useRouter();

onMounted(async () => {
  await fetchTasks();
  await fetchProjects();
});

const fetchTasks = async () => {
  try {
    const response = await axios.get('/tasks');
    tasks.value = response.data;
  } catch (error) {
    console.error('获取任务列表失败', error);
  }
};

const fetchProjects = async () => {
  try {
    const response = await axios.get('/projects');
    projects.value = response.data;
  } catch (error) {
    console.error('获取项目列表失败', error);
  }
};

const getProjectName = (projectId) => {
  const project = projects.value.find(p => p.id === projectId);
  return project ? project.name : '未知项目';
};

const deleteTask = async (id) => {
  if (confirm('确定要删除该任务吗？')) {
    try {
      await axios.delete(`/tasks/${id}`);
      await fetchTasks();
    } catch (error) {
      console.error('删除任务失败', error);
    }
  }
};
</script>