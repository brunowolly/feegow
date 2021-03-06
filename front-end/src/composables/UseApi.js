import { api } from "boot/axios";

export function useApi(url) {
  const list = async () => {
    try {
      const data = await api.get(url);
      return data;
    } catch (error) {
      throw new Error(error);
    }
  };

  const getById = async (id) => {
    try {
      const data = await api.get(`${url}/${id}`);
      return data;
    } catch (error) {
      throw new Error(error);
    }
  };

  const post = async (form) => {
    try {
      const { data } = await api.post(url, form);
      return data;
    } catch (error) {
      throw new Error(error);
    }
  };

  const listHow = async () => {
    try {
      const data = await api.get(url);
      return data;
    } catch (error) {
      throw new Error(error);
    }
  };

  return {
    list,
    post,
    getById,
    listHow,
  };
}
