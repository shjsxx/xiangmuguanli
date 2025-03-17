<template>
  <div>
    <h2>{{ isEditMode ? '编辑任务' : '新建任务' }}</h2>
    <form @submit.prevent="submitForm">
      <div class="mb-3">
        <label for="projectId" class="form-label">所属项目</label>
        <select class="form-select" id="projectId" v-model="form.project_id" required>
          <option value="" disabled>请选择项目</option>
          <option v-for="project in projects" :key="project.id" :value="project.id">
            {{ project.name }}
          </option>
        </select>
      </div>
      <div class="mb-3">
        <label for="name" class="form-label">任务名称</label>
        <input type="text" class="form-control" id="name" v-model="form.name" required>
      </div>
      <div class="mb-3">
        <label for="description" class="form-label">任务描述</label>
        <textarea class="form-control" id="description" v-model="form.description"></textarea>
      </div>
      <div class="mb-3">
        <label for="dueDate" class="form-label">截止日期</label>
        <input type="date" class="form-control" id="dueDate" v-model="form.due_date">
      </div>
      <button type="submit" class="btn btn-primary">{{ isEditMode ? '更新任务' : '创建任务' }}</button>
      <router-link to="/tasks" class="btn btn-secondary ms-2">取消</router-link>
    </form>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import { useRouter, useRoute } from 'vue-router';

const router = useRouter();
const route = useRoute();
const taskId = ref(route.params.id);
const isEditMode = ref(!!taskId.value);
const projects = ref();
const form = ref({
  project_id: route.query.project_id ? parseInt(route.query.project_id) : '',
  name: '',
  description: '',
  due_date: '',
});

onMounted(async () => {
  await fetchProjects();
  if (isEditMode.value) {
    await fetchTask();
  }
});

const fetchProjects = async () => {
  try {
    const response = await axios.get('/projects');
    projects.value = response.data;
  } catch (error) {
    console.error('获取项目列表失败', error);
  }
};

const fetchTask = async () => {
  try {
    const response = await axios.get(`/tasks/${taskId.value}`);
    form.value = response.data;
  } catch (error) {
    console.error('获取任务信息失败', error);
    router.push('/tasks');
  }
};

const submitForm = async () => {
  try {
    if (isEditMode.value) {
      await axios.put(`/tasks/${taskId.value}`, form.value);
      console.log('任务更新成功');
    } else {
      await axios.post('/tasks', form.value);
      console.log('任务创建成功');
    }
    router.push('/tasks');
  } catch (error) {
    console.error('提交失败', error);
  }
};
</script>