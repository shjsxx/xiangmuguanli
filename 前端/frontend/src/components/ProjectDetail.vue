<template>
  <div>
    <h2>项目详情</h2>
    <div v-if="project">
      <h3>{{ project.name }}</h3>
      <p><strong>类型:</strong> {{ project.type }}</p>
      <p><strong>状态:</strong> {{ project.status }}</p>
      <p><strong>开始日期:</strong> {{ project.start_date }}</p>
      <p><strong>完成日期:</strong> {{ project.end_date }}</p>
      <p><strong>内容:</strong> {{ project.content }}</p>

      <h4>子项目</h4>
      <ul v-if="project.subprojects && project.subprojects.length > 0">
        <li v-for="subproject in project.subprojects" :key="subproject.id">
          <router-link :to="`/projects/${subproject.id}`">{{ subproject.name }}</router-link>
        </li>
      </ul>
      <p v-else>暂无子项目</p>

      <h4>任务列表</h4>
      <router-link :to="`/tasks/create?project_id=${project.id}`" class="btn btn-success btn-sm mb-3">添加任务</router-link>
      <table class="table">
        <thead>
          <tr>
            <th>名称</th>
            <th>状态</th>
            <th>截止日期</th>
            <th>操作</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="task in project.tasks" :key="task.id">
            <td>{{ task.name }}</td>
            <td>{{ task.status }}</td>
            <td>{{ task.due_date }}</td>
            <td>
              <router-link :to="`/tasks/${task.id}/edit`" class="btn btn-sm btn-warning me-2">编辑</router-link>
              <button @click="deleteTask(task.id)" class="btn btn-sm btn-danger">删除</button>
            </td>
          </tr>
        </tbody>
      </table>
      <p v-else>暂无任务</p>
    </div>
    <div v-else>
      <p>加载中...</p>
    </div>
    <router-link to="/projects" class="btn btn-secondary mt-3">返回项目列表</router-link>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import { useRoute, useRouter } from 'vue-router';

const route = useRoute();
const router = useRouter();
const projectId = ref(route.params.id);
const project = ref(null);

onMounted(async () => {
  await fetchProjectDetails();
});

const fetchProjectDetails = async () => {
  try {
    const response = await axios.get(`/projects/${projectId.value}`);
    project.value = response.data;
  } catch (error) {
    console.error('获取项目详情失败', error);
    router.push('/projects'); // 如果找不到项目，返回列表页
  }
};

const deleteTask = async (taskId) => {
  if (confirm('确定要删除该任务吗？')) {
    try {
      await axios.delete(`/tasks/${taskId}`);
      await fetchProjectDetails(); // 刷新项目详情，包括任务列表
    } catch (error) {
      console.error('删除任务失败', error);
    }
  }
};
</script>