import { useMutation, useQueryClient } from 'react-query';
import { createPayment } from '.';

const useCreatePayment = () => {
  const queryClient = useQueryClient();
  queryClient.setMutationDefaults(['create-Payment'], {
    mutationFn: (data) => createPayment(data),
    onMutate: async (variables) => {
      const { successCb, errorCb } = variables;
      return { successCb, errorCb };
    },
    onSuccess: (result, variables, context) => {
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

export default useCreatePayment;
