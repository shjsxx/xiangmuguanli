<template>
  <div>
    <h2>{{ isEditMode ? '编辑项目' : '新建项目' }}</h2>
    <form @submit.prevent="submitForm">
      <div class="mb-3">
        <label for="name" class="form-label">项目名称</label>
        <input type="text" class="form-control" id="name" v-model="form.name" required>
      </div>
      <div class="mb-3">
        <label for="type" class="form-label">项目类型</label>
        <select class="form-select" id="type" v-model="form.type">
          <option value="">请选择</option>
          <option value="研发">产品研发</option>
          <option value="市场">市场推广</option>
          <option value="运营">运营活动</option>
        </select>
      </div>
      <div class="mb-3">
        <label for="content" class="form-label">项目内容</label>
        <textarea class="form-control" id="content" v-model="form.content"></textarea>
      </div>
      <div class="mb-3">
        <label for="startDate" class="form-label">开始日期</label>
        <input type="date" class="form-control" id="startDate" v-model="form.start_date">
      </div>
      <div class="mb-3">
        <label for="endDate" class="form-label">完成日期</label>
        <input type="date" class="form-control" id="endDate" v-model="form.end_date">
      </div>
      <button type="submit" class="btn btn-primary">{{ isEditMode ? '更新项目' : '创建项目' }}</button>
      <router-link to="/projects" class="btn btn-secondary ms-2">取消</router-link>
    </form>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import { useRouter, useRoute } from 'vue-router';

const router = useRouter();
const route = useRoute();
const projectId = ref(route.params.id);
const isEditMode = ref(!!projectId.value);
const form = ref({
  name: '',
  type: '',
  content: '',
  start_date: '',
  end_date: '',
});

onMounted(async () => {
  if (isEditMode.value) {
    await fetchProject();
  }
});

const fetchProject = async () => {
  try {
    const response = await axios.get(`/projects/${projectId.value}`);
    form.value = response.data;
  } catch (error) {
    console.error('获取项目信息失败', error);
    router.push('/projects');
  }
};

const submitForm = async () => {
  try {
    if (isEditMode.value) {
      await axios.put(`/projects/${projectId.value}`, form.value);
      console.log('项目更新成功');
    } else {
      await axios.post('/projects', form.value);
      console.log('项目创建成功');
    }
    router.push('/projects');
  } catch (error) {
    console.error('提交失败', error);
  }
};
</script>