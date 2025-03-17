<template>
  <div>
    <h2>项目列表</h2>
    <router-link to="/projects/create" class="btn btn-primary mb-3">新建项目</router-link>
    <table class="table">
      <thead>
        <tr>
          <th>名称</th>
          <th>类型</th>
          <th>状态</th>
          <th>开始日期</th>
          <th>完成日期</th>
          <th>操作</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="project in projects" :key="project.id">
          <td>{{ project.name }}</td>
          <td>{{ project.type }}</td>
          <td>{{ project.status }}</td>
          <td>{{ project.start_date }}</td>
          <td>{{ project.end_date }}</td>
          <td>
            <router-link :to="`/projects/${project.id}`" class="btn btn-sm btn-info me-2">查看</router-link>
            <router-link :to="`/projects/${project.id}/edit`" class="btn btn-sm btn-warning me-2">编辑</router-link>
            <button @click="deleteProject(project.id)" class="btn btn-sm btn-danger">删除</button>
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

const projects = ref();
const router = useRouter();

onMounted(async () => {
  await fetchProjects();
});

const fetchProjects = async () => {
  try {
    const response = await axios.get('/projects');
    projects.value = response.data;
  } catch (error) {
    console.error('获取项目列表失败', error);
  }
};

const deleteProject = async (id) => {
  if (confirm('确定要删除该项目吗？')) {
    try {
      await axios.delete(`/projects/${id}`);
      await fetchProjects();
    } catch (error) {
      console.error('删除项目失败', error);
    }
  }
};
</script>