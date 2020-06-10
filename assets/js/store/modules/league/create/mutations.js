import * as types from './mutation_types';

export default {
  [types.LEAGUE_CREATE_SET_ERROR](state, error) {
    Object.assign(state, { error });
  },

  [types.LEAGUE_CREATE_TOGGLE_LOADING](state) {
    Object.assign(state, { error: '', isLoading: !state.isLoading });
  },

  [types.LEAGUE_CREATE_SET_CREATED](state, created) {
    Object.assign(state, { created });
  },

  [types.LEAGUE_CREATE_SET_VIOLATIONS](state, violations) {
    Object.assign(state, { violations });
  },

  [types.LEAGUE_CREATE_RESET](state) {
    Object.assign(state, {
      created: null,
      error: '',
      isLoading: false,
      violations: null,
    });
  },
};
