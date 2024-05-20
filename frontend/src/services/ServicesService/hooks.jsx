import { useMutation, useQueryClient } from 'react-query';
import { createService, deleteService, updateService } from '.';

const useCreateService = () => {
  const queryClient = useQueryClient();
  queryClient.setMutationDefaults(['create-Service'], {
    mutationFn: (data) => createService(data),
    onMutate: async (variables) => {
      const { successCb, errorCb } = variables;
      return { successCb, errorCb };
    },
    onSuccess: (result, variables, context) => {
      queryClient.invalidateQueries('unpaidServices');
      queryClient.invalidateQueries('customerServices');
      if (context.successCb) {
        context.successCb(result);
      }
    },
    onError: (error, variables, context) => {
      if (context.errorCb) {
        context.errorCb(error);
      }
    },
  });
  return useMutation(['create-Service']);
};

const useDeleteService = () => {
  const queryClient = useQueryClient();
  queryClient.setMutationDefaults(['delete-Service'], {
    mutationFn: (data) => deleteService(data),
    onMutate: async (variables) => {
      const { successCb, errorCb } = variables;
      return { successCb, errorCb };
    },
    onSuccess: (result, variables, context) => {
      queryClient.invalidateQueries('unpaidServices');
      queryClient.invalidateQueries('customerServices');
      queryClient.invalidateQueries('expiredServices');
      if (context.successCb) {
        context.successCb(result);
      }
    },
    onError: (error, variables, context) => {
      if (context.errorCb) {
        context.errorCb(error);
      }
    },
  });
  return useMutation(['delete-Service']);
};

const useUpdateService = (id) => {
  const queryClient = useQueryClient();

  queryClient.setMutationDefaults(['update-Service'], {
    mutationFn: (payload) => updateService(id, payload),
    onMutate: async (variables) => {
      const { successCb, errorCb } = variables;
      return { successCb, errorCb };
    },
    onSuccess: (result, variables, context) => {
      queryClient.invalidateQueries('unpaidServices');
      queryClient.invalidateQueries('customerServices');
      queryClient.invalidateQueries('expiredServices');
      if (context.successCb) {
        context.successCb(result);
      }
    },
    onError: (error, variables, context) => {
      if (context.errorCb) {
        context.errorCb(error);
      }
    },
  });
  return useMutation(['update-Service']);
};

export { useCreateService, useDeleteService, useUpdateService };
